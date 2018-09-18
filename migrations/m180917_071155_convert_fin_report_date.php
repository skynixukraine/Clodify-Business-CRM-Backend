<?php

use yii\db\Migration;

/**
 * Class m180917_071155_convert_fin_report_date
 */
class m180917_071155_convert_fin_report_date extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $reports = \app\models\FinancialReport::find()->all();
        Yii::$app->db
            ->createCommand('UPDATE ' . \app\models\FinancialReport::tableName() . ' SET report_date=NULL WHERE 1')
            ->execute();
        $this->alterColumn(\app\models\FinancialReport::tableName(), 'report_date', 'DATE');

        foreach ($reports as $rep ) {

            $rep->report_date = \app\components\DateUtil::convertDateFromUnix($rep->report_date, 'Y-m-d');

            $rep->save(false, ['report_date']);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180917_071155_convert_fin_report_date cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180917_071155_convert_fin_report_date cannot be reverted.\n";

        return false;
    }
    */
}
