<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m181115_091112_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username'=>$this->string()->notNull()->defaultValue(""),
            'score'=>$this->integer()->notNull()->defaultValue(0),
            'class'=>$this->integer()->notNull()->defaultValue(0),
            'grade'=>$this->integer()->notNull()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}
