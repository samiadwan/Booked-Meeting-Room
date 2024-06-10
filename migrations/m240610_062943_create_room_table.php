<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%room}}`.
 */
class m240610_062943_create_room_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%room}}', [
            'id' => $this->primaryKey(),
            'room_name' => $this->string(50)->notNull(),
            'status' => $this->string(10)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%room}}');
    }
}
