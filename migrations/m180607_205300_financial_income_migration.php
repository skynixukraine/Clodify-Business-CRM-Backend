<?php

use yii\db\Migration;

/**
 * Class m180607_205300_financial_income_migration
 */
class m180607_205300_financial_income_migration extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('financial_income', 'financial_report_id', $this->integer(11));

        $this->addForeignKey(
            'fk_financial_income_fin',
            'financial_income',
            'financial_report_id',
            'financial_reports',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $projectId = \app\models\Project::find()->where(['name' => \app\models\Project::INTERNAL_TASK])->one()->id;
        $reports = \app\models\FinancialReport::find()->all();
        foreach ( $reports as $report ) {

            if ( ( $incomeItems = json_decode($report->income, true) ) &&
            count($incomeItems)) {

                foreach ( $incomeItems as $item ) {

                    if ( isset($item['amount']) && isset($item['description']) && isset($item['date']) ) {

                        $finIncomeItem = new \app\models\FinancialIncome();
                        $finIncomeItem->amount      = (float)$item['amount'];
                        $finIncomeItem->description = $item['description'];
                        $finIncomeItem->date        = (int)$item['date'];
                        $finIncomeItem->project_id  = $projectId;
                        $finIncomeItem->added_by_user_id    = 1;
                        $finIncomeItem->developer_user_id   = 1;
                        $finIncomeItem->save();

                    }

                }

            }

        }
        $this->dropColumn('financial_reports', 'income');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180607_205300_financial_income_migration cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180607_205300_financial_income_migration cannot be reverted.\n";

        return false;
    }
    */
}
