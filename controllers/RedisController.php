<?php
namespace app\controllers;

use app\models\RedisQueue;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;

class RedisController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRedisCounter()
    {
        $redis=new \Redis();
        $redis->connect('127.0.0.1');
    }

    //counter name
    public function actionGetKeyName($v)
    {
        return "mycounter_".$v;
    }

    public function actionWriteLog($msg,$v)
    {
        $log=$msg.PHP_EOL;
        file_put_contents("log/$v.log",$log,FILE_APPEND);
    }

    public function v1()
    {
        //賞金の上限
         $amountLimit = 100;
         //カウンター名を取得
         $keyName = $this->actionGetKeyName('v1');
         //redisを起動
         $redis = new \Redis();
         $redis->connect('127.0.0.1');
         $incrAmount = 1;

         if(!$redis->exists($keyName)){
             //もしカウンター存在しなければ、新規制作
             $redis->set($keyName,95);
         }
         //現在のvalを取得
         $currAmount=$redis->get($keyName);
         if($currAmount +$incrAmount >$amountLimit)
         {
             //もし現在valと増加val足して　賞金の上限超える場合
             //外れに入る
             $this->actionWriteLog("bad luck",'v1');
             return;
         }
         //redisに変換を書き込む
         $redis->incrBy($keyName,$incrAmount);
         $this->actionWriteLog("good luck",'v1');
    }

    public function v2()
    {
        //賞金の上限
        $amountLimit = 100;
        //カウンター名を取得
        $keyName = $this->actionGetKeyName('v2');
        //redisを起動
        $redis = new \Redis();
        $redis->connect('127.0.0.1');
        $incrAmount = 1;
        if(!$redis->exists($keyName))
        {
            $redis->setnx($keyName,95);
        }
        //現在のvalを取得
        $currAmount=$redis->get($keyName);
        if($redis->incrBy($keyName,$incrAmount)>$amountLimit){
            $this->actionWriteLog("bad luck",'v2');
            return;
        }
        $this->actionWriteLog("Good luck",'v2');
    }

    public function actionRedisTest()
    {
        $request = new Request();
        if($request->isGet)
        {
            $v=$request->get('v');
            if($v == 2){
                $this->v2();
            }else{
                $this->v1();
            }
        }
    }
//==============================================================================
    //SecKill 商品秒杀
    public function actionRedisSecKill()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1');
        $redis->delete('SecKill');
        $redis_name='SecKill';


        $request = new Request();
        if($request ->isGet)
        {
            //大量購入の真似
            for ($i=0;$i<100;$i++)
            {
                $uid=rand(100000,999999);

            //ユーザーidを取得
            //$uid=$request->get('uid');
            //redis内の数を取得
            $num=10;
            if ($redis->lLen($redis_name)<10)
            {
              //もし10までいかなければ,listへ挿入
                $redis->rPush($redis_name,$uid.'%'.microtime());
                echo $uid.'購入成功';

            }else {
                //でなければSecKill完成とリターンする
                echo '商品売り切れ';
             }
            }
            $redis->close();
        }
    }
    //save to db
    public function actionSaveRedis()
    {
        $redis= new \Redis();
        $redis->connect('127.0.0.1');
        $redis_name='SecKill';
        //データベースへ接続
        $redisUser=new RedisQueue();
        //ループ
        while(1) {
            //左からデータを取得
            $user=$redis->lPop($redis_name);
            //存在してるかどうかを判断する
            if(!$user || $user == 'nil'){
                //sleep(2);
                continue;
            }
            //時間とuidを取得
            $user_arr=explode('%',$user);
            $insert_data=array(
              'uid'=>$user_arr[0],
              'time_stamp'=>$user_arr[1],
            );
            //データベースへ保存
            $redisUser->uid=$insert_data['uid'];
            $redisUser->time_stamp=$insert_data['time_stamp'];
            $res= $redisUser->save();
            //保存に失敗すれば,データをredisへ戻す
            if(!$res){
                $redis->rPush($redis_name,$user);
            }
            //sleep(2);
        }
        //redisのデータをクリーン
        $redis->close();

    }


    public $enableCsrfValidation = false;
    //スクリーンショットテスト
    public function actionTest()
    {
        //$file = $_FILES['my-image-file'];
        $request = new Request();
        if($request->isPost)
        {
            //$img=UploadedFile::getInstanceByName('blob');
            $file = $_FILES['my-image-file'];

            if ($file['error'] == 0) {
            define('ROOT', __DIR__);
            if (is_uploaded_file($file['tmp_name'])) {
                $ext = explode('/', $file['type'])[1];
                $filename = "{$file['name']}_" . date("ymdHis") . ".{$ext}";
                $mu = move_uploaded_file($file["tmp_name"], \Yii::getAlias('@webroot') . "/upload/" . $filename);
                if ($mu) {
                    exit(json_encode(['id' => 1, 'src' => '/upload/' . $filename,'height'=>'200']));
                } else {
                    exit(json_encode(['id' => 2, 'msg' => 'move file fail']));
                }
            } else {
                exit(json_encode(['id' => 2, 'msg' => 'failed no post']));
            }
        } else {
            exit(json_encode(['id' => 2, 'msg' => $file['error']]));
        }

        }

//
    }
}