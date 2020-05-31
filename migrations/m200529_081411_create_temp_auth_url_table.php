<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%temp_auth_url}}`.
 */
class m200529_081411_create_temp_auth_url_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%temp_auth_url}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string('64')->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime(),
        ]);

        $this->createIndex(
            'idx-temp_auth_url-user_id',
            'temp_auth_url',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-temp_auth_url-user_id',
            'temp_auth_url',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%temp_auth_url}}');

        $this->dropForeignKey(
            'fk-temp_auth_url-user_id',
            'temp_auth_url'
        );

        $this->dropIndex(
            'idx-temp_auth_url-user_id',
            'temp_auth_url'
        );
    }
}
