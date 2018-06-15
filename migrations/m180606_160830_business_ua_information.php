<?php

use yii\db\Migration;

/**
 * Class m180606_160830_business_ua_information
 */
class m180606_160830_business_ua_information extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('busineses', 'name_ua', $this->string(250));
        $this->addColumn('busineses', 'address_ua', $this->string(250));
        $this->addColumn('busineses', 'represented_by_ua', $this->string(250));
        $this->addColumn('busineses', 'bank_information_ua', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180606_160830_business_ua_information cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180606_160830_business_ua_information cannot be reverted.\n";

        return false;
    }
    */
}
