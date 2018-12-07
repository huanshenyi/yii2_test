<?php
namespace app\controllers;

use app\models\Student;
use yii\web\controller;


class StudentController extends controller{

//検証用のcsrfを閉じる
//public $enableCsrfValidation=false;
//学生の増加
public function actionAdd()
    {
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
             $name = $_POST['name'];
             $age = $_POST['age'];
             $student = new Student();
             $student->name = $name;
             $student->age = $age;
             $student->save();

             return $this->redirect(['student/index']);
      }
      return $this->render('add');
    }


//学生リスト
public function actionIndex(){

  $students = Student::find()->all();

  return $this->render('index',[

    'students'=>$students
  ]);

}

}





?>
