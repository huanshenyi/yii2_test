<?php
namespace app\models;

use yii\db\ActiveRecord;

class category extends ActiveRecord
{
 //1対1の関係を作る
 //goods テーブルとの1対多の関係
 public function getGoods()
 {
   return $this->hasMany(Goods::className(),['category_id'=>'id']);

 }

}



 ?>
