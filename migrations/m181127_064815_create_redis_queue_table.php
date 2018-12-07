<?php

use yii\db\Migration;

/**
 * Handles the creation of table `redis_queue`.
 */
class m181127_064815_create_redis_queue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('redis_queue', [
            'id' => $this->primaryKey(),
            'uid'=>$this->integer()->notNull()->defaultValue(0),
            'time_stamp'=>$this->string(24)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('redis_queue');
    }
}
