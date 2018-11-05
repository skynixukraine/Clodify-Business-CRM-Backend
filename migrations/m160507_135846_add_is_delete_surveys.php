<?php


use app\components\SkynixMigration;


class m160507_135846_add_is_delete_surveys extends SkynixMigration
{
    public function up()
    {
        $this->addColumn( 'surveys', 'is_delete', 'tinyint(1) DEFAULT 0');
    }

    public function down()
    {
        echo "m160507_135846_add_is_delete_surveys cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
