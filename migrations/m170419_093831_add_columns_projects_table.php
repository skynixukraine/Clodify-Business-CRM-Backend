<?php

use yii\db\Migration;

class m170419_093831_add_columns_projects_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn( 'projects', 'description', $this->text());
        $this->addColumn( 'projects', 'photo', $this->string(255));
        $this->addColumn( 'projects', 'is_published', $this->boolean()->defaultValue(false));
    }

    public function safeDown()
    {
        $this->dropColumn('projects', 'description');
        $this->dropColumn('projects', 'photo');
        $this->dropColumn('projects', 'is_published');
    }

}
