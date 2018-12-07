<?
namespace app\models;

use yii\base\Model;


class StudentForm extends Model
{
public $name;
public $password;
public $sex;
public $city;
public $hobby;
public $intro;

public function attributeLabels()
{
 return[
   'name'=>'名前',
   'password'=>'暗証番号',
   'sex'=>'性別',
   'city'=>'町',
   'hobby'=>'趣味',
   'intro'=>'自己紹介',
 ];
}

public function rules()
{
  return[
     [['name','sex','password','city','hobby'],'required'],//一つ【】が一つのルール


  ];

}




}
