<?php

use yii\db\Schema;
use yii\db\Migration;

class m160415_184608_create_notifications_table extends Migration
{
    public function up()
    {
        $this->createTable('notifications', [
            'id' => $this->primaryKey(),

            'user_id_from' => $this->integer()
                              ->notNull(), # notification will be from an user

            'user_id_to' => $this->integer()
                              ->notNull(), # notification will be to an user

            'content' => $this->text(),

            'read' => $this->smallInteger()
                             ->defaultValue(0), # 0 - Unread, 1 - Read

            'status' => $this->smallInteger()
                             ->defaultValue(1), # 0 - Disabled, 1 - Active

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
            'idx-notifications-user_id_from',
            'notifications',
            'user_id_from'
        );

        # Add a foreign key on user_id_from
        $this->addForeignKey(
            'fk-notifications-user_id_from',
            'notifications',
            'user_id_from',
            'users',
            'id',
            'CASCADE'
        );

        # Add an index on user_id_to to make it a foreign key
        $this->createIndex(
            'idx-notifications-user_id_to',
            'notifications',
            'user_id_to'
        );

        # Add a foreign key on user_id_to
        $this->addForeignKey(
            'fk-notifications-user_id_to',
            'notifications',
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
            'fk-notifications-user_id_from',
            'notifications'
        );

        # Drop index for user_id_from
        $this->dropIndex(
            'idx-notifications-user_id_from',
            'notifications'
        );

        # Drop foreign key for user_id_to
        $this->dropForeignKey(
            'fk-notifications-user_id_to',
            'notifications'
        );

        # Drop index for user_id_to
        $this->dropIndex(
            'idx-notifications-user_id_to',
            'notifications'
        );
        
        $this->dropTable('notifications');
    }
}
