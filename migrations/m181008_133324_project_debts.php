<?php

 use app\components\SkynixMigration;

/**
 * Class m181008_133324_project_debts
 */
class m181008_133324_project_debts extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('project_debts', [
            'id'            => $this->primaryKey(),
            'project_id'    => $this->integer(),
            'amount'        => $this->integer(),
            'financial_report_id' => $this->integer(),
        ]);

        // add foreign key for table `availability_logs`
        $this->addForeignKey(
            'fk_project_debts_financial_reports',
            'project_debts',
            'financial_report_id',
            'financial_reports',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_project_debts_projects',
            'project_debts',
            'project_id',
            'projects',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181008_133324_project_debts cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181008_133324_project_debts cannot be reverted.\n";

        return false;
    }
    */
}
