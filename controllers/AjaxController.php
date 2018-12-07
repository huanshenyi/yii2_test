<?php
namespace app\controllers;

use app\models\User;
use app\models\UserExcel;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Session;

class AjaxController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionIndex2()
    {
        return $this->render('index2');
    }

    //テスト
    public function actionIndex3()
    {
        return $this->render('index3');

    }
    //vue
    public function actionIndex4()
    {
        return $this->render('index4');
    }
    //データベースのデータと照合
    public function actionIndex5()
    {
        return $this->render('index5');
    }


    public function actionYiiAjax()
    {
        $request=new Request();
        if($request->isGet)
        {
            echo "getだよ";
        }
    }

    public function actionGetAjax()
    {
      $username = $_GET['username'];

      if($username == "admin")
      {
          echo 0;

      }else{
          echo 1;
      }
    }

    public function actionPostAjax()
    {
        $this->enableCsrfValidation = false;
         $request=new Request();
         if($request->isPost){
             $username=$request->post('username');
             if($username=="admin"){
                 return json_encode(['status'=>'0']);
             }else{
                return json_encode(['status'=>'1']);
             }
         }
    }

    public function actionVueAjax()
    {
        $request=new Request();
        if($request->isPost){
            $tesx=$request->post();
            return json_encode($tesx);
        }
    }

    public function actionAjaxCheck()
    {
       $request=new Request();
       if($request->isPost){
           $username=$request->post('username');

           $user=UserExcel::find()->where(['username'=>$username])->one();
           if($user != null){
               echo '存在します';
           }else{
               echo '存在しない';
           }
       }

    }

}