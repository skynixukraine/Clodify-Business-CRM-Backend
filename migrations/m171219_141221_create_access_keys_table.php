<?php

use yii\db\Migration;

/**
 * Handles the creation of table `access_keys`.
 */
class m171219_141221_create_access_keys_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('access_keys', [
            'id' => $this->primaryKey(),
            'expand' => $this->string(100),
            'token' => $this->string(255),
            'expiry_date' => $this->integer(),
            'email' => $this->string(100),
            'first_name' => $this->string(255),
            'last_name' => $this->string(255),
            'user_id' => $this->integer(),

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('access_keys');
    }
}
