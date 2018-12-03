<?php

 use app\components\SkynixMigration;

/**
 * Handles the creation of table `email_templates`.
 */
class m180822_092951_create_email_templates_table extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('email_templates', [
            'id' => $this->primaryKey(),
            'subject' => $this->string('255'),
            'reply_to' => $this->string('255'),
            'body' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('email_templates');
    }
}
