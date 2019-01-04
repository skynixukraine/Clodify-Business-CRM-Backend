<?php

use app\components\SkynixMigration;

/**
 * Class m190103_203015_change_salary_report_date
 */
class m190103_203015_change_salary_report_date extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $list = \app\models\SalaryReport::find()->all();
        $this->update(\app\models\SalaryReport::tableName(), [
            'report_date'   => null
        ], 1);
        $this->alterColumn(\app\models\SalaryReport::tableName(), 'report_date', 'DATE');


        if ( $list ) {

            foreach ( $list as $rep ) {
                $y = date('Y', $rep->report_date);
                $m = date('m', $rep->report_date);
                $date = $y . "-" . $m . '-01';
                $lastDay = date("t", strtotime($date));
                $this->update(\app\models\SalaryReport::tableName(), [
                    'report_date'   => $y . "-" . $m . "-" . $lastDay
                ], ['id' => $rep->id]);

            }
        }


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190103_203015_change_salary_report_date cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190103_203015_change_salary_report_date cannot be reverted.\n";

        return false;
    }
    */
}
