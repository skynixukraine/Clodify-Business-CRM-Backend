<?php

use yii\db\Migration;

class m160517_131145_add_column_photo_and_sign extends Migration
{
    public function safeUp()
    {
        $this->addColumn('users','photo', $this->string(255));
        $this->addColumn('users', 'sing', $this->string(255));
    }

    public function down()
    {
        echo "m160517_131145_add_column_photo_and_sign cannot be reverted.\n";

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
