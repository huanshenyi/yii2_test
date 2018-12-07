<?php
namespace app\controllers;

use app\models\UserExcel;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;

class UserExcelController extends Controller
{
    //データ一覧
    public function actionIndex()
    {
        $data=UserExcel::find();
        $pages=new Pagination(['totalCount'=>$data->count(), 'pageSize' => '10']);
        $models =$data->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index',['models'=>$models,'pages'=>$pages]);

    }
    //挿入
    public function actionAdd()
    {
        $model= new UserExcel();
        $request = new Request();
        if($request->isPost)
        {
            $model->load($request->post());
            if($model->validate())
            {
                $model->save();
                \Yii::$app->session->setFlash('info','追加しました');
                return $this->redirect(['user-excel/index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }

        return $this->render('add',['model'=>$model]);
    }
    //修正
    public function actionEdit($id)
    {
        $model= UserExcel::findOne(['id'=>$id]);
        $request = new Request();
        if($request->IsPost){

            $model->load($request->post());
            if($model->validate()){
                $model->save();
                return $this->redirect(['user-excel/index']);
            }else {
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('add',['model'=>$model]);
    }

    //excelの出力
    public function actionExcel()
    {
        $objPHPExcel = new \PHPExcel();
        for($i=1;$i<=3;$i++)
        {
            if($i>1) {
                $objPHPExcel->createSheet();//内部シードを作る
            }
            $objPHPExcel->setActiveSheetIndex($i-1);//新しく作られたシードを現在操作シードに設定
            $objSheet=$objPHPExcel->getActiveSheet();//現在操作シードを取得
            $objSheet->setTitle('クラス'.$i);//該当シードにタイトル付ける
            $UserExcel= UserExcel::findAll(['grade'=>$i]);//goods表の分類idでデータを取得
            $objSheet->setCellValue("A1","名前")->setCellValue("B1","点数")->setCellValue("C1","クラス");
            $j=2;
            foreach ($UserExcel as $key=>$good)
            {
                $objSheet->setCellValue("A".$j,$good['username'])->setCellValue("B".$j,$good['score'])->setCellValue("C".$j,$good['class']);
                $j++;
            }
        }
        $objWriter=\PHPExcel_IOFactory::createWriter($objPHPExcel,"Excel2007");//ファイルを生成
        //$objWriter->save(\Yii::getAlias("@webroot") .'/excel/'.'demo_2.xlsx');//ファイル内保存用
        $this->browser_export("Excel2007","browser_excel03.xlsx");//ブラウザで出力
        $objWriter->save("php://output");
    }

    //ブラウザ出力のpublic方法
    public function browser_export($type,$filename)
    {
        if($type == "Excel5")
        {
            header('Content-Type: application/vnd.ms-excel');//ブラウザにexcel03の出力を伝える
        }else{
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');//ブラウザにexcel07の出力を伝える
        }
        header('Content-Disposition: attachment;filename="'.$filename.'"');//ブラウザに出力ファイルのタイトルを伝える
        header('Cache-Control: max-age=0');//セッションを禁止
    }

    //デザイン入りの出力
    public function actionExcel1()
    {
        $objPHPExcel = new \PHPExcel();
        $objSheet=$objPHPExcel->getActiveSheet();//使用シードを取得
        //文字の真ん中寄せ設定
        $objSheet->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //デフォルトスタール設定
        $objSheet->getDefaultStyle()->getFont()->setName("HGP教科書体")->setSize("14");
        $objSheet->getStyle("A2:Z2")->getFont()->setSize(20)->setBold(true);//学年の行の文字デザイン
        $objSheet->getStyle("A3:Z3")->getFont()->setSize(16)->setBold(true);//クラスの行の文字デザイン

        //スタート
        //すべての学年を探し出す
        $grade= UserExcel::find()->select('grade')->distinct('grade')->orderBy('grade ASC')->asArray()->all();
        //学年によって属するくらいを探し出す

        //出力時に改行用
        $index=0;

        foreach ($grade as $key=>$vals)
        {
            //学年の列位置を取得
            $gradeIndex=$this->actionGetCells($index*2);

            $objSheet->setCellValue($gradeIndex."2",$vals['grade']."年");

            $class = UserExcel::find()->select('class')->distinct('class')->where(['grade'=>$vals])->orderBy('class ASC')->asArray()->all();
            //クラスに属する学生を探す
            foreach ($class as $key=>$val)
            {
                //シードで位置を取る
                $nameIndex=$this->actionGetCells($index*2);//クラスごとの学生の名前ある列位置を取得
                $scoreIndex=$this->actionGetCells($index*2+1);//クラスごとの学生の点数ある列位置を取得

                $objSheet->mergeCells($nameIndex."3:".$scoreIndex."3"); //クラスごとシードの合併

                $objSheet->getStyle($nameIndex."3:".$scoreIndex."3")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB("52e351"); //クラス列の色塗のコード

                $classBorderStyle=$this->getBorderStyle('e351ca');
                $objSheet->getStyle($nameIndex."3:".$scoreIndex."3")->applyFromArray($classBorderStyle);//クラスある行の枠線設定

                $students=UserExcel::find()->where(['class'=>$val])->andWhere(['grade'=>$vals])->orderBy('score DESC')->asArray()->all();//学生データ

                $objSheet->setCellValue($nameIndex."4","名前")->setCellValue($scoreIndex."4","点数"); //タグデータを入力

                $objSheet->setCellValue($nameIndex."3",$val['class']."クラス");//クラスタグ入り
                $j=5;
                foreach ($students as $key => $student)
                {
                    $objSheet->setCellValue($nameIndex.$j,$student['username'])->setCellValue($scoreIndex.$j,$student['score']);//学生データを挿入
                    $j++;
                }
                $index++;
            }
            //学年ごと終わるシード位置取得取得
            $endGradeIndex=$this->actionGetCells($index*2-1);
            //シードを合併 :はここからの意味
            $objSheet->mergeCells($gradeIndex."2:".$endGradeIndex."2");
            //学年列色塗のコード
            $objSheet->getStyle($gradeIndex."2:".$endGradeIndex."2")->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB("e36951");
            $gradeBorderStyle=$this->getBorderStyle("e3df51");//クラスがある行の枠線スタールを取得
            //学年の枠線を設定
            $objSheet->getStyle($gradeIndex."2:".$endGradeIndex."2")->applyFromArray($gradeBorderStyle);
        }
        $objWriter=\PHPExcel_IOFactory::createWriter($objPHPExcel,"Excel2007");//ファイルを生成
        //$objWriter->save(\Yii::getAlias("@webroot") .'/excel/'.'demo_2.xlsx');//ファイル内保存用
        $this->browser_export("Excel2007","browser_excel03.xlsx");//ブラウザで出力
        $objWriter->save("php://output");
    }

    //シードの(列)位置取得用

    public function actionGetCells($index)
    {
        $arr=range('A','Z');//$arr= array(A,B,C,D..Z)
        return $arr[$index];

    }

    //枠線ひきスタール設定
    public function getBorderStyle($color)
    {
        $styleArray=array(
            'borders'=>array(
                'outline'=>array(
                    'style'=>\PHPExcel_Style_Border::BORDER_THICK,
                    'color'=>array('rgb'=>$color),
                ),
            ),
        );
        return $styleArray;
    }

    //excelの画像挿入 rm -rf /
    public function actionExcelImg()
    {
        $objPHPExcel=new \PHPExcel();
        $objSheet=$objPHPExcel->getActiveSheet();//使用するシードを取得
        //画像挿入関連begin
        $objDrawing=new \PHPExcel_Worksheet_Drawing();//操作する画像のオブジェクトを取得
        $objDrawing->setPath(\Yii::getAlias('@webroot').'/image/'.'9.jpg');//画像のある位置を取得,urlはダメ
        $objDrawing->setCoordinates('F6');//左上座標の設定
        $objDrawing->setWidth(500);//画像の大きさ設定自動的にバランス調整してくれる
        //$objDrawing->setHeight(100);//ですので、大きさの調整はその設定する回数分だけ調整される
        //$objDrawing->setOffsetX(20)->setOffsetY(10);//シード内の偏り量の設定->設定可能の量はシードある量だけ
        $objDrawing->setWorksheet($objSheet);//画像を現在使用してシードへ挿入
        //画像挿入関連end

        //テキスト操作begin
        $objRichText=new \PHPExcel_RichText();//テキスト操作オブジェクトを取得
        $objRichText->createText("テキスト操作");//普通の文字,スタイル操作できない
        $objStyleFont=$objRichText->createTextRun("今回はテキスト操作やります");//スタールつけられるテキストを挿入
        $objStyleFont->getFont()->setSize(16)->setBold(True)
            ->setColor(new \PHPExcel_Style_Color(\PHPExcel_Style_Color::COLOR_GREEN));//スタールを追加/文字の大きさ/色
        $objRichText->createText('テスト中');
        $objSheet->getCell("F4")->setValue($objRichText);//テキストをシードへ挿入
        //テキスト操作end

        //コメント挿入コードbegin
        $objSheet->mergeCells("F4:N4");//シードを合併
        $objSheet->getComment("F4")->getText()->createTextRun("Van:\r\nテスト\n\n手数料明細書");//コメント挿入
        //コメント挿入コードend

        //リンクの挿入
        $objSheet->setCellValue('I3','my love');//文字挿入
                                                             //文字太く　　　　　　//文字下に線を引く
        $objSheet->getStyle('I3')->getFont()->setSize(16)->setBold(true)->setUnderline(true)
            ->setColor(new \PHPExcel_Style_Color(\PHPExcel_Style_Color::COLOR_BLUE));//スタールを挿入
        $objSheet->getCell('I3')->getHyperlink()->setUrl('https://www.imooc.com');//リンクを挿入hrefの役割
        //

        $objWriter=\PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
        $this->browser_export('Excel2007','browser_excel03.xlsx');
        $objWriter->save("php://output");
    }

    //excelグラフ出力
    public function actionGraph()
    {
        $objPHPExcel=new \PHPExcel();
        //今回の内容
        $objSheet=$objPHPExcel->getActiveSheet();//現在操作するシードを取得

        $array=array(
            array("","1組","2組","3組"),
            array("不合格",20,30,40),
            array("合格",30,50,55),
            array("優秀",15,17,20),
        );//データの用意
        $objSheet->fromArray($array);//データを挿入
        //グラフコード
        $labels=array(
            new \PHPExcel_Chart_DataSeriesValues('String','Worksheet!$B$1',null,1),//1組
            new \PHPExcel_Chart_DataSeriesValues('String','Worksheet!$C$1',null,1),//2組
            new \PHPExcel_Chart_DataSeriesValues('String','Worksheet!$D$1',null,1),//3組
        );//グラフのラベルを取得
        $xLabels=array(
            new \PHPExcel_Chart_DataSeriesValues('String','Worksheet!$A$2:$A$4',null,3),//グラフxラインのラベルを取得
        );
        //
        $datas=array(
            new \PHPExcel_Chart_DataSeriesValues('Number','Worksheet!$B$2:$B$4',null,3),//グラフxラインのラベルを取得
            new \PHPExcel_Chart_DataSeriesValues('Number','Worksheet!$C$2:$C$4',null,3),//グラフxラインのラベルを取得
            new \PHPExcel_Chart_DataSeriesValues('Number','Worksheet!$D$2:$D$4',null,3),//グラフxラインのラベルを取得
        );//グラフ用のデータ

        $series=array(
            new \PHPExcel_Chart_DataSeries(
                \PHPExcel_Chart_DataSeries::TYPE_LINECHART,
                \PHPExcel_Chart_DataSeries::GROUPING_STACKED,
                range(0,count($labels)-1),
                $labels,
                $xLabels,
                $datas
            )
        );//グラフの骨組みを生成
        $layout=new \PHPExcel_Chart_Layout();
        $layout->setShowVal(true);
        $areas=new \PHPExcel_Chart_PlotArea($layout,$series);
        $legend=new \PHPExcel_Chart_Legend(\PHPExcel_Chart_Legend::POSITION_RIGHT,null,false);
        $title=new \PHPExcel_Chart_Title("一年学生成績分布");
        $ytitle=new \PHPExcel_Chart_Title("value(人数)");
        $chart=new \PHPExcel_Chart(
            'line_chart',
            $title,
            $legend,
            $areas,
            true,
            false,
            null,
            $ytitle
        );//グラフを生成
        $chart->setTopLeftPosition("A7")->setBottomRightPosition("K25");//

        $objSheet->addChart($chart);//chartをExcelへ


        //ウェブへ出力のコード
        $objWriter=\PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');

        $objWriter->setIncludeCharts(true);
        $this->browser_export('Excel2007','browser_chart.xlsx');
        $objWriter->save("php://output");

    }

    //excelファイルの読み込み
    public function actionReader()
    {
        $filename= \Yii::getAlias('@webroot').'/excel/'.'b.xlsx';

        //シード選択の読み込み
        $fileType=\PHPExcel_IOFactory::identify($filename);//アップロードされたファイルのタイプ取得し/phpexcelに提供
        $objReader=\PHPExcel_IOFactory::createReader($fileType);//ファイル読み込みクラスを取得
        $sheetName=array("商品区分2","商品区分3");//読み込みシードの設定
        $objReader->setLoadSheetsOnly($sheetName);

        $objPHPExcel=$objReader->load($filename);//ファイルをロード
        //シード選択の読み込みを完結

        //$objPHPExcel=\PHPExcel_IOFactory::load($filename);//ファイルをロード
      //  $sheetCount=$objPHPExcel->getSheetCount();//ファイルにシードの数を取得
//        for($i=0;$i<$sheetCount;$i++){
//         $data= $objPHPExcel->getSheet($i)->toArray();//シード内のデータをすべて読み込み、arrayに入れる
//            print_r($data);
//        }

        foreach ($objPHPExcel->getWorksheetIterator() as $sheet)
        {
            foreach ($sheet->getRowIterator() as $row)//行を読み込み
            {
                if($row->getRowIndex()<2)
                {
                    continue;
                }
                foreach ($row->getCellIterator() as $cell)//列を読み込み
                {
                    $data=$cell->getValue();//データを取得
                    echo $data." ";
                }
                echo '<br/>';
            }
            echo '<br/>';
        }
        exit();
    }
}