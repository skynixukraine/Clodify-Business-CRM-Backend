<?php

 use app\components\SkynixMigration;

/**
 * Class m180626_095445_add_from_to_dates_for_income
 */
class m180626_095445_add_from_to_dates_for_income extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('financial_income', 'from_date', $this->integer(11));
        $this->addColumn('financial_income', 'to_date', $this->integer(11));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180626_095445_add_from_to_dates_for_income cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180626_095445_add_from_to_dates_for_income cannot be reverted.\n";

        return false;
    }
    */
}
