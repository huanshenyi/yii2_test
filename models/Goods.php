<?php
namespace app\models;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Goods extends ActiveRecord
{
//categoryテーブルとの1対１関係を築く
public function getCategory()
{
  return $this->hasOne(Category::className(),['id'=>'category_id']);

}


public function rules(){
 return[
  [['name','sn','total','detail','price','category_id'],'required'],
  ['price','double','message'=>'数字を入力してください'],
 ];
}

public function attributeLabels(){

return  ['name'=>'名前',
  'sn'=>'商品番号',
  'price'=>'値段',
  'total'=>'在庫',
  'detail'=>'紹介',
  'category_id'=>'商品分類',
];
}

public static function getCategoryOptions()
{
 // $categories=Category::find()->all();
 // $items =[];
 // foreach ($categories as $category){
 //   $items[$category->id]=$category->name;
 // }
 // return $items;
 return ArrayHelper::map(Category::find()->all(),'id','name');

}


}


?>
