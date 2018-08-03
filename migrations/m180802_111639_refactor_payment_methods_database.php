<?php

use yii\db\Migration;
use yii\db\Query;

/**
 * Class m180802_111639_refactor_payment_methods_database
 */
class m180802_111639_refactor_payment_methods_database extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {


        $this->dropForeignKey('fk-contracts-contract_payment_method_id', 'contracts');
        $this->dropColumn('payment_methods', 'description');

        $this->truncateTable('payment_methods');

        $this->addColumn('payment_methods', 'name_alt', 'string');
        $this->addColumn('payment_methods', 'address_alt', 'string');
        $this->addColumn('payment_methods', 'represented_by_alt', 'string');
        $this->addColumn('payment_methods', 'bank_information_alt', 'text');
        $this->addColumn('payment_methods', 'is_default', 'boolean');
        $this->addColumn('payment_methods', 'business_id', 'integer');


        $data = (new Query())
            ->select('*')
            ->from('busineses')
            ->all();


        if(!empty($data)) {
            foreach($data as $elem) {

                $columns = ['name', 'name_alt', 'address_alt', 'represented_by_alt', 'bank_information_alt'];

                $insert_data['name'] = $elem['name'];
                $insert_data['name_alt'] = $elem['name'];
                $insert_data['address_alt'] = $elem['address'];
                $insert_data['represented_by_alt'] = $elem['represented_by'];
                $insert_data['bank_information_alt'] = $elem['bank_information'];

                $this->batchInsert('payment_methods', $columns, [$insert_data]);
            }
        }

        $this->dropColumn('busineses', 'invoice_increment_id');
        $this->dropColumn('busineses', 'represented_by');
        $this->dropColumn('busineses', 'bank_information');
        $this->dropColumn('busineses', 'name_ua');
        $this->dropColumn('busineses', 'address_ua');
        $this->dropColumn('busineses', 'represented_by_ua');
        $this->dropColumn('busineses', 'bank_information_ua');

        $this->addColumn('busineses', 'is_default', 'boolean');
        $this->addForeignKey('business_id', 'payment_methods', 'business_id', 'busineses', 'id');

        $this->addColumn('invoices', 'payment_method_id', 'integer');

        $invoices = (new Query())
            ->select('*')
            ->from('invoices')
            ->all();


        if(!empty($invoices)) {
            foreach($invoices as $elem) {
                $this->update('invoices', ['payment_method_id' => $elem['business_id']], 'invoices.id = ' . $elem['id']);
            }
        }
//
//        $this->dropColumn('invoices', 'business_id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->addForeignKey('fk-contracts-contract_payment_method_id', 'contracts', 'contract_payment_method_id', 'payment_methods', 'id');
        $this->addColumn('payment_methods', 'description', 'string');


        $this->dropColumn('payment_methods', 'name_alt');
        $this->dropColumn('payment_methods', 'address_alt');
        $this->dropColumn('payment_methods', 'represented_by_alt');
        $this->dropColumn('payment_methods', 'bank_information_alt');
        $this->dropColumn('payment_methods', 'is_default');
        $this->dropColumn('payment_methods', 'business_id');


        $this->addColumn('busineses', 'invoice_increment_id', 'integer');
        $this->addColumn('busineses', 'represented_by', 'string');
        $this->addColumn('busineses', 'bank_information', 'text');
        $this->addColumn('busineses', 'name_ua', 'string');
        $this->addColumn('busineses', 'address_ua', 'string');
        $this->addColumn('busineses', 'represented_by_ua', 'string');
        $this->addColumn('busineses', 'bank_information_ua', 'text');

        $this->dropForeignKey('business_id', 'payment_methods');
        $this->dropColumn('invoices', 'payment_method_id');
//
//        $this->dropColumn('busineses', 'is_default');
//
//        $this->addColumn('invoices', 'business_id', 'integer');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180802_111639_refactor_payment_methods_database cannot be reverted.\n";

        return false;
    }
    */
}
