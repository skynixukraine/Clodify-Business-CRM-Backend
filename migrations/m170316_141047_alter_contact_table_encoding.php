<?php

use yii\db\Migration;

class m170316_141047_alter_contact_table_encoding extends Migration
{
    public function up()
    {

        $this->execute("ALTER TABLE contact CONVERT TO CHARACTER SET utf8");

    }

    public function down()
    {
        echo "m170316_141047_alter_contact_table_encoding cannot be reverted.\n";

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
