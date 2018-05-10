<?php

use yii\db\Migration;

/**
 * Class m180427_080045_alter_table_delayed_salary
 */
class m180427_080046_labor_expenses_ratio extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->insert('settings', [
            'key'   => 'LABOR_EXPENSES_RATIO',
            'value' => 20,
            'type'  =>'INT'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m180427_080046_labor_expenses_ratio cannot be reverted.\n";

        return false;
    }

}
