<?php

use yii\db\Migration;

class m170419_091723_add_columns_users_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn( 'users', 'languages', $this->string(255));
        $this->addColumn( 'users', 'position', $this->string(255));
        $this->addColumn( 'users', 'birthday', $this->timestamp()->defaultValue(null));
        $this->addColumn( 'users', 'experience_year', $this->integer()->defaultValue(0));
        $this->addColumn( 'users', 'degree', $this->string(255)->defaultValue('No Degree'));
        $this->addColumn( 'users', 'residence', $this->string(255));
        $this->addColumn( 'users', 'link_linkedin', $this->string(255));
        $this->addColumn( 'users', 'link_video', $this->string(255));
        $this->addColumn( 'users', 'is_published', $this->boolean()->defaultValue(false));
    }

    public function safeDown()
    {
        echo "m170419_091723_add_columns_users_table cannot be reverted.\n";

        $this->dropColumn('users', 'languages');
        $this->dropColumn('users', 'position');
        $this->dropColumn('users', 'birthday');
        $this->dropColumn('users', 'experience_year');
        $this->dropColumn('users', 'degree');
        $this->dropColumn('users', 'residence');
        $this->dropColumn('users', 'link_linkedin');
        $this->dropColumn('users', 'link_video');
        $this->dropColumn('users', 'is_published');

        return false;
    }

}
