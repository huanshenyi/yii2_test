<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order_queue`.
 */
class m181122_080944_create_order_queue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order_queue', [
            'id' => $this->primaryKey(),
            'order_id'=>$this->integer(11)->notNull()->defaultValue(0),
            'mobile'=>$this->string(20)->notNull()->defaultValue(0),//携帯番号
            'created_at'=>$this->dateTime()->notNull()->defaultValue(0),
            'updated_at'=>$this->dateTime()->notNull()->defaultValue(0),
            'status'=>$this->integer()->notNull()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('order_queue');
    }
}
