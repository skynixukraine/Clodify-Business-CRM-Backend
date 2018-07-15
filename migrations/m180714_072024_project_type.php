<?php

use yii\db\Migration;

/**
 * Class m180714_072024_project_type
 */
class m180714_072024_project_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('projects', 'type', 'ENUM("HOURLY", "FIXED_PRICE") DEFAULT "HOURLY"');
        $this->createTable('milestones', [
            'id'            => $this->primaryKey()->notNull() . ' AUTO_INCREMENT',
            'project_id'    => $this->integer(11),
            'name'          => $this->text(),
            'status'        =>'enum( "NEW", "CLOSED")',
            'estimated_amount'  =>  $this->integer(),
            'start_date'    => $this->date(),
            'end_date'      => $this->date(),
            'closed_date'   => $this->date()
        ]);
        $this->addForeignKey('fk_milestones_projects', 'milestones', 'project_id', 'projects', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180714_072024_project_type cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180714_072024_project_type cannot be reverted.\n";

        return false;
    }
    */
}
