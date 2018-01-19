<?php

use yii\db\Migration;

class m180118_094629_add_column_authtype_to_users extends Migration
{
    public function up()
    {
        $this->addColumn( 'users', 'auth_type', 'tinyint(1) DEFAULT 1');
    }

    public function down()
    {
        $this->dropColumn('users', 'auth_type');
    }
}
