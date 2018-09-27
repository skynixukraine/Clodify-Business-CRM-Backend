<?php

use yii\db\Migration;

/**
 * Class m180927_153514_add_invoice_template_vars
 */
class m180927_153514_add_invoice_template_vars extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('invoice_templates', 'variables', $this->text());
        $variables = "{id} - the invoice id
{appAlias} - the link to application alias
{dateInvoiced} - the date when was invoiced
{supplierName} - the name of a supplier
{supplierAddress} - the address of a supplier
{supplierDirector} - the name of supplier director
{supplierNameUa} - the name of supplier in Ukrainian
{supplierAddressUa} - the address of a supplier in Ukrainian
{supplierDirectorUa} - the name of supplier director in Ukrainian
{customerCompany} - the name of a customer's company
{customerAddress} - the address of a customer
{customerName} - the customer name
{currency} - the currency
{priceTotal} - the total price
{supplierBank} - the bank of a supplier
{supplierBankUa} - the bank of a supplier in Ukrainian
{customerBank} - the bank of a customer
{customerBankUa} - the bank of a customer in Ukrainian
{dataFrom} - the start data of software development 
{dataTo} - the end date of software development
{dataFromUkr} - the start data of software development in Ukrainian
{dataToUkr} - the end date of software development in Ukrainian
{dateToPay} - the payment date
{signatureContractor} - the signature of contractor
{signatureCustomer} - the signature of customer";
        $this->update('invoice_templates', ['variables' => $variables], 'id=:id', [':id' => 1]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180927_153514_add_invoice_template_vars cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180927_153514_add_invoice_template_vars cannot be reverted.\n";

        return false;
    }
    */
}
