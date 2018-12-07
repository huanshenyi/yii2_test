<?php
namespace app\controllers;

use yii\captcha\Captcha;
use yii\data\Pagination;
use yii\web\Controller;
//use yii\web\Category;
use app\models\Category;
use app\models\Goods;
use yii\web\Request;


class GoodsController extends controller
{

 //商品リスト
public function actionIndex(){
 //全ての商品データを取得 形式は配列[]
 $data=Goods::find();
 $pages=new Pagination(['totalCount' =>$data->count(), 'pageSize' => '10']);
 $models=$data->offset($pages->offset)->limit($pages->limit)->all();
 //データをビューに渡す
 return $this->render('index',['models'=>$models,'pages'=>$pages]);

}
 //1.1商品を増加
 public function actionAdd(){
  //1.2モデルを実体化
  $model = new Goods();
  //フォームデータを受け取るそしてセーブする
  $request= new Request();
  if($request->IsPost){
     //フォームデータを受ける
     $model->load($request->post());
     //データの検証
     if($model->validate()){
        
       $model->create_time = time();
       $model->save();
       //リスト画面へ飛ぶ
       return $this->redirect(['goods/index']);
     }else {
       var_dump($model->getErrors());exit;
     }
  }
  //2.1モデルをビューに渡す

  return $this->render('add',['model'=>$model]);

 }

 //商品修正
 public function actionEdit($id)
 {
   //id使用して商品を選択
   $model = Goods::findone(['id'=>$id]);
   $request = new Request();
   if($request->IsPost){

      $model->load($request->post());
      if($model->validate()){
        $model->save();
        return $this->redirect(['goods/index']);
      }else {
        var_dump($model->getErrors());exit;
      }
   }
   return $this->render('add',['model'=>$model]);

 }

   //excelの普通テスト
    public function actionTest()
    {
        $model= new \PHPExcel();
        $objSheet= $model->getActiveSheet();//内部シードを作る
        $objSheet->setTitle('demo');
        //普通のデータ注入
        /*$objSheet->setCellValue("A1","名前")->setCellValue("B1","点数");
        $objSheet->setCellValue("A2","tanio")->setCellValue('B2',50);*/
        //文字列注入
        $array=array(
            //一行目からでなければ、空の配列を入れればオーケー
            //列の最初にカンマ区切りしたければ　からの " "を挿入すればいい
            array(),
            array("","名前","点数"),
            array("","tanio","60"),
            array("","tanio2","30"),
        );
        $objSheet->fromArray($array);
        $objWriter= \PHPExcel_IOFactory::createWriter($model,"Excel2007");//指定出力する時の形式
        $objWriter->save(\Yii::getAlias("@webroot") .'/excel/'.'demo_1.xlsx');
    }

    //データベースからデータ出力のテスト
    public function actionTest2()
    {
        $objPHPExcel= new \PHPExcel();
        //category_idは3まであるので ループで三つの内部シードを作る
        for($i=1;$i<=3;$i++)
        {
            if($i>1) {
                $objPHPExcel->createSheet();//内部シードを作る
            }
            $objPHPExcel->setActiveSheetIndex($i-1);//新しく作られたシードを現在操作シードに設定
            $objSheet=$objPHPExcel->getActiveSheet();//現在操作シードを取得
            $objSheet->setTitle('商品区分'.$i);//該当シードにタイトル付ける
            $goods= Goods::findAll(['category_id'=>$i]);//goods表の分類idでデータを取得
            $objSheet->setCellValue("A1","名前")->setCellValue("B1","商品番号")->setCellValue("C1","値段");
            $j=2;
            foreach ($goods as $key=>$good)
            {
                $objSheet->setCellValue("A".$j,$good['name'])->setCellValue("B".$j,$good['sn'])->setCellValue("C".$j,$good['price']);
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

    //デザインつけのExcel出力
    public function actionTest3()
    {
        //商品の分類数を取得
        $Categorys = Category::find()->count();
        for ($i=1;$i<=$Categorys;$i++)
        {
            //分類数使って商品データの取得
            $goods=Goods::findAll(['category_id'=>$i]);

        }


    }
}

?>
