<?php

use yii\db\Migration;

/**
 * Handles the creation of table `transactions`.
 */
class m171109_093636_create_transactions_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('transactions', [
            'id' =>  $this->integer()->notNull(),
            'type'=> "enum('DEBIT', 'CREDIT')",
            'name' => $this->string(255),
            'date' => $this->integer(),
            'amount' => $this->decimal(15,2),
            'currency' => "enum('USD', 'UAH')",
            'reference_book_id' => $this->integer()->notNull(),
            'counterparty_id' => $this->integer()->notNull(),
            'operation_id' => $this->integer()->notNull(),
            'operation_business_id' => $this->integer()->notNull(),
            'PRIMARY KEY(id, operation_id, operation_business_id)',
        ],$tableOptions);

        // creates index for column `reference_book_id`
        $this->createIndex(
            'fk_transactions_reference_book_idx',
            'transactions',
            'reference_book_id'
        );


        // add foreign key for table `reference_book`
        $this->addForeignKey(
            'fk_transactions_reference_book',
            'transactions',
            'reference_book_id',
            'reference_book',
            'id',
            'NO ACTION',
            'NO ACTION'
        );

        // creates index for column `counterparty_id`
        $this->createIndex(
            'fk_transactions_counterparties1_idx',
            'transactions',
            'counterparty_id'
        );

        // add foreign key for table `counterparties`
        $this->addForeignKey(
            'fk_transactions_counterparties1',
            'transactions',
            'counterparty_id',
            'counterparties',
            'id',
            'NO ACTION',
            'NO ACTION'
        );

        // creates index for column `operation_id`
        $this->createIndex(
            'fk_transactions_operations1_idx',
            'transactions',
            'operation_id, operation_business_id'
        );


        // add foreign key for table `operations`
        $this->addForeignKey(
            'fk_transactions_operations1',
            'transactions',
            'operation_id, operation_business_id, ',
            'operations',
            'id, business_id',
            'NO ACTION',
            'NO ACTION'
        );

    }

    public function safeDown()
    {

        // drops foreign key for table reference_book
        $this->dropForeignKey(
            'fk_transactions_reference_book',
            'transactions'
        );

        // drops index for column reference_book_id
        $this->dropIndex(
            'fk_transactions_reference_book_idx',
            'transactions'
        );

        // drops foreign key for table counterparties
        $this->dropForeignKey(
            'fk_transactions_counterparties1',
            'transactions'
        );

        // drops index for column counterparty_id
        $this->dropIndex(
            'fk_transactions_counterparties1_idx',
            'transactions'
        );

        // drops foreign key for table operations
        $this->dropForeignKey(
            'fk_transactions_operations1',
            'transactions'
        );

        // drops index for column operation_id
        $this->dropIndex(
            'fk_transactions_operations1_idx',
            'transactions'
        );

        $this->dropTable('transactions');
    }
}
