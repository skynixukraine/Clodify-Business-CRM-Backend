<?php

 use app\components\SkynixMigration;

/**
 * Class m180607_195455_financial_income
 */
class m180607_195455_financial_income extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('financial_income', [
            'id'                => $this->primaryKey(),
            'date'              => $this->integer(),
            'amount'            => $this->double(),
            'description'       => $this->text(),
            'project_id'        => $this->integer(),
            'added_by_user_id'  => $this->integer(),
            'developer_user_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk_financial_income_users',
            'financial_income',
            'added_by_user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_financial_income_projects',
            'financial_income',
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
        echo "m180607_195455_financial_income cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180607_195455_financial_income cannot be reverted.\n";

        return false;
    }
    */
}
