<?php


use app\components\SkynixMigration;


class m160322_090400_fix_ref extends SkynixMigration
{
    public function up()
    {

/*        $this->getDb()->createCommand('DROP VIEW `excluded`;')->execute();
        $this->getDb()->createCommand('DROP VIEW `included`;')->execute();
*/

        //$this->getDb()->createCommand('DROP VIEW `excluded`;')->execute();
        //$this->getDb()->createCommand('DROP VIEW `included`;')->execute();


        $this->dropForeignKey('fk_monthly_reports_users1', 'monthly_reports');
        $this->addForeignKey('fk_monthly_reports_users1', 'monthly_reports', 'user_id', 'users', 'id');

    }

    public function down()
    {
        echo "m160322_090400_fix_ref cannot be reverted.\n";

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
