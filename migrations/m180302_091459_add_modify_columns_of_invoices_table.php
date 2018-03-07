<?php

use yii\db\Migration;

class m180302_091459_add_modify_columns_of_invoices_table extends Migration
{
    public function up()
    {
        $this->addColumn( 'invoices', 'business_id', $this->integer());
        $this->addColumn( 'invoices', 'currency', $this->string(5)->defaultValue('USD'));
        $this->dropColumn( 'invoices', 'payment_method_id');
        $this->dropColumn( 'invoices', 'user_projects');

    }

    public function down()
    {
        echo "m180302_091459_add_modify_columns_of_invoices_table cannot be reverted.\n";

        return false;
    }
}