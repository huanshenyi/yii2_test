<?php
namespace app\controllers;

use app\models\StudentForm;
use yii\web\Controller;
use yii\web\Request;


class Day2Controller extends controller
{
   //redisテスト
   public function actionRedis()
   {
      $redis = new \Redis();
      $redis->connect('127.0.0.1');
      var_dump($redis->get('name'));

   }
   //redisテスト
    public function actionRedis1()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1');

        /* stringタイプの操作*/
//        $redis->delete("string1");
//        $redis->set("string1","val1");
//        $val=$redis->get("string1");
//        var_dump($val);
//        $redis->set("c1",4);
//        //valを2を増やす
//        $redis->incr("string1",2);
//        $val=$redis->get("string1");
//        var_dump($val);

        /* listタイプの操作*/
//        $redis->delete("list1");
//        $redis->lPush("list1","A");
//        $redis->lPush("list1","B");
//        $redis->lPush("list1","C");
//
//        $val=$redis->rPop("list1");
//        var_dump($val);

        /* setタイプの操作 setのデータは唯一性がある*/
//        $redis->delete("set1");
//        $redis->sAdd("set1","A");
//        $redis->sAdd("set1","B");
//        $redis->sAdd("set1","C");
//        $redis->sAdd("set1","C");
//        $val=$redis->sCard("set1");
//        var_dump($val);
//        $val=$redis->sMembers("set1");
//        var_dump($val);

         /* HASH値の操作 key val保存用*/
//        $redis->delete("driver1");
                                //key    //val
//        $redis->hSet("driver1",'name','mingming');
//        $redis->hSet("driver1","age",25);
//        $redis->hSet("driver1","gender",1);
//        //一つのキーを取得
//        $val= $redis->hGet("driver1",'name');
//        var_dump($val); // 'mingming'
//        $val=$redis->hMGet("driver1",array("name","age","gender"));
//        var_dump($val); /*'name' => string 'mingming' (length=8)
//  'age' => string '25' (length=2)

           /* sort set 順番つけ配列で感じ*/
           $redis->delete('zset1');
           $redis->zAdd("zset1",100,"xiaoming");
           $redis->zAdd("zset1",81,"xiaohong");
           $redis->zAdd("zset1",60,"tanio");
           $val=$redis->zRange("zset1",0,-1);//低くから高くへ
           var_dump($val);
        /*array (size=3)
  0 => string 'tanio' (length=5)
  1 => string 'xiaohong' (length=8)
  2 => string 'xiaoming' (length=8)*/
        $val=$redis->zRevRange("zset1",0,-1);//高くから低くへ
        var_dump($val);
        /*array (size=3)
  0 => string 'xiaoming' (length=8)
  1 => string 'xiaohong' (length=8)
  2 => string 'tanio' (length=5)*/

    }
    //Redisテスト
    public function actionRedisTest()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1');
        //とあるキー存在してるかどうか
        //var_dump($redis->exists('zset1'));

    }
    //Redisのcounter
    public function actionRedisCounter()
    {
        $redis=new \Redis();
        $redis->connect('127.0.0.1');

    }

    public function actionIndex()
    {
        return $this->render('index');
    }





   public function actionWeather()
   {
    //$city = $_GET['city'];
    $url = 'http://t.weather.sojson.com/api/weather/city/101030100';//インターフェース
    $str = file_get_contents($url);
    $data = json_decode($str,true);
    var_dump($data);

    //return $this->render('',['data'=>$data]);
   }

   //Activeformパーツの使用
   public function actionForm()
   {
     //modelを作る
     $model =  new StudentForm();
     return $this->render('form',['model',$model]);
   }

}





