<?php

use yii\db\Schema;
use yii\db\Migration;

class m160414_112353_create_users_table extends Migration
{
    public function up()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),

            'email' => $this->string()
                            ->notNull() # Email can not be blank
                            ->unique(), # Email should be unique

            'password' => $this->string()
                               ->notNull(), # Password can not be blank

            'role' => $this->smallInteger()
                           ->defaultValue(2), # 1 - Admin, 2 - User

            'status' => $this->smallInteger()
                             ->defaultValue(1), # 0 - Disabled User, 1 - Active User

            # Timestamps to track changes
            # Using Schema Builder to avoid default timestamp bugs
            # Bug URL: https://github.com/yiisoft/yii2/issues/9574
            'created_at' => Schema::TYPE_TIMESTAMP
                            . ' NULL DEFAULT CURRENT_TIMESTAMP ',
            'updated_at' => Schema::TYPE_TIMESTAMP
                            . ' NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP '
        ]);

        # Add an index on email for fast selection
        $this->createIndex(
            'idx-users-email',
            'users',
            'email'
        );
    }

    public function down()
    {
        # Drop the index first
        $this->dropIndex(
            'idx-users-email',
            'users'
        );

        $this->dropTable('users');
    }
}
