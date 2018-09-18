<?php

use yii\db\Migration;

/**
 * Handles the creation of table `invoice_template`.
 */
class m180823_082338_create_invoice_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('invoice_template', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'body' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('invoice_template');
    }
}
