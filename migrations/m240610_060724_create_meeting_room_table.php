<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%meeting_room}}`.
 */
class m240610_060724_create_meeting_room_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%meeting_room}}', [
            'id' => $this->primaryKey(),
             'roomName' => $this->string(50)->notNull(),
             'status' => $this->string(10)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%meeting_room}}');
    }
}
