<?php
namespace app\controllers;

use yii\web\Controller;

class  ExcelController extends Controller
{
    public function actionTest()
    {
       $model= new \PHPExcel();
       $objSheet= $model->getActiveSheet();
       $objSheet->setTitle('demo');
       $objSheet->setCellValue("A1","名前")->setCellValue("B1","点数");
       $objSheet->setCellValue("A2","tanio")->setCellValue('B2',50);
       $objWriter= \PHPExcel_IOFactory::createWriter($model,"Excel2007");//指定
        $objWriter->save("@webroot".'/excel/'.'demo.xlsx');
    }



}