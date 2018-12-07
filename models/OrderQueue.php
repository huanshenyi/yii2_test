<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_queue".
 *
 * @property int $id
 * @property int $order_id
 * @property string $mobile
 * @property string $created_at
 * @property string $updated_at
 * @property int $status
 */
class OrderQueue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_queue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['mobile'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => '注文ID',
            'mobile' => '携帯番号',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
