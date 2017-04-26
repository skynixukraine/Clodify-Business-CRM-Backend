<?php

use yii\db\Migration;

class m170426_080723_add_slug_column_to_users extends Migration
{
    public function up()
    {
        $this->addColumn( 'users', 'slug', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('users', 'slug');
    }
}
