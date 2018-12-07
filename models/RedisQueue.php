<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "redis_queue".
 *
 * @property int $id
 * @property int $uid
 * @property string $time_stamp
 */
class RedisQueue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'redis_queue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid'], 'integer'],
            [['time_stamp'], 'required'],
            [['time_stamp'], 'string', 'max' => 24],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'time_stamp' => 'Time Stamp',
        ];
    }
}
