<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category2}}`.
 */
class m240607_081755_create_category2_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category2}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(50)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%category2}}');
    }
}
