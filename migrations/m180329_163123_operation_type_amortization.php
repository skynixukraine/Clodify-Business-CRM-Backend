<?php

use yii\db\Migration;

/**
 * Class m180329_163123_operation_type_amortization
 */
class m180329_163123_operation_type_amortization extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert( \app\models\OperationType::tableName(), [
           'name' => \Yii::t('app', 'Amortization')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180329_163123_operation_type_amortization cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180329_163123_operation_type_amortization cannot be reverted.\n";

        return false;
    }
    */
}
