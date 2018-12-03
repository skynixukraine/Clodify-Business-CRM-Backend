<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 06.11.17
 * Time: 10:25
 */

 use app\components\SkynixMigration;

class m171103_072238_create_report_actions_tbl extends SkynixMigration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('report_actions', [
            'id' => $this->primaryKey(),
            'report_id' => $this->integer(),
            'user_id' => $this->integer(),
            'action' => $this->string(200),
            'datetime' => $this->integer()
        ],$tableOptions);
    }

    public function down()
    {
        echo "m171103_072238_create_report_actions_tbl cannot be reverted.\n";

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
