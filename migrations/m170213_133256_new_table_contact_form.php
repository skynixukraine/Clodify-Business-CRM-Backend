<?php

use yii\db\Migration;

class m170213_133256_new_table_contact_form extends Migration
{
    public function up()
    {
        $this->createTable('contact', [
            'id' => $this->primaryKey(),
            'name' => $this->string(45),
            'email' => $this->string(150),
            'message' => $this->string(150),
            'subject' => $this->string(45),
            'verifyCode' => $this->string(250),
            'attachments' => $this->text()
        ]);

        $this->createTable('contact', [
            'id' => $this->primaryKey()->notNull() . ' AUTO_INCREMENT',
            'name' => 'varchar(45)',
            'email' => 'varchar(150)',
            'message' => 'varchar(150)',
            'subject' => 'varchar(45)',
            'verifyCode' => 'varchar(250)',
            'attachment' => 'varchar(250)'
        ]);
    }

    public function down()
    {
        echo "m170213_133256_new_table_contact_form cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
