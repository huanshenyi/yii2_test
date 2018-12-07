<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property int $score
 * @property int $class
 * @property int $grade
 */
class UserExcel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['class','grade'],'in','range'=>[1,2,3],'message'=>'学年やクラスは1から3まで'],
            [['username','score','class','grade'],'required'],
            [['score', 'class', 'grade'], 'integer'],
            [['username'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '名前',
            'score' => '成績',
            'class' => 'クラス',
            'grade' => '学年',
        ];
    }
}
