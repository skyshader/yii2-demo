<?php

use yii\db\Schema;
use yii\db\Migration;

class m160415_124725_create_messages_table extends Migration
{
    public function up()
    {
        $this->createTable('messages', [
            'id' => $this->primaryKey(),

            'user_id_from' => $this->integer()
                              ->notNull(), # messags will always be from an user

            'user_id_to' => $this->integer()
                              ->notNull(), # messags will always be sent to an user

            'message' => $this->text(),

            'status' => $this->smallInteger()
                             ->defaultValue(1), # 0 - Disabled Message, 1 - Active Message

            # Timestamps to track changes
            # Using Schema Builder to avoid default timestamp bugs
            # Bug URL: https://github.com/yiisoft/yii2/issues/9574
            'created_at' => Schema::TYPE_TIMESTAMP
                            . ' NULL DEFAULT CURRENT_TIMESTAMP ',
            'updated_at' => Schema::TYPE_TIMESTAMP
                            . ' NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP '
        ]);

        # Add an index on user_id_from to make it a foreign key
        $this->createIndex(
            'idx-messages-user_id_from',
            'messages',
            'user_id_from'
        );

        # Add a foreign key on user_id_from
        $this->addForeignKey(
            'fk-messages-user_id_from',
            'messages',
            'user_id_from',
            'users',
            'id',
            'CASCADE'
        );

        # Add an index on user_id_to to make it a foreign key
        $this->createIndex(
            'idx-messages-user_id_to',
            'messages',
            'user_id_to'
        );

        # Add a foreign key on user_id_to
        $this->addForeignKey(
            'fk-messages-user_id_to',
            'messages',
            'user_id_to',
            'users',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        # Drop foreign key for user_id_from
        $this->dropForeignKey(
            'fk-messages-user_id_from',
            'messages'
        );

        # Drop index for user_id_from
        $this->dropIndex(
            'idx-messages-user_id_from',
            'messages'
        );

        # Drop foreign key for user_id_to
        $this->dropForeignKey(
            'fk-messages-user_id_to',
            'messages'
        );

        # Drop index for user_id_to
        $this->dropIndex(
            'idx-messages-user_id_to',
            'messages'
        );

        $this->dropTable('messages');
    }
}
