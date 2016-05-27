<?php

use yii\db\Migration;
use app\models\User;

class m160527_053653_table_support_tickets_support_ticket_comments extends Migration
{
    public function safeUp()
    {
        $this->createTable('support_tickets', [
            'id' => $this->primaryKey()->notNull() . ' AUTO_INCREMENT',
            'subject'=>'varchar(250)',
            'description'=>$this->text(),
            'is_private'=>'tinyint(1) DEFAULT 0',
            'assignet_to'=>$this->integer(11),
            'status'=>'enum( "NEW", "ASSIGNED", "COMPLETED", "CANCELLED")',
            'client_id'=>$this->integer(),
            'date_added'=>$this->dateTime(),
            'date_completed'=>$this->dateTime(),
        ]);
        $this->createTable('support_ticket_comments', [
            'id' => $this->primaryKey()->notNull() . ' AUTO_INCREMENT',
            'comment'=>$this->text(),
            'date_added'=>$this->dateTime(),
            'user_id'=>$this->integer(),
            'support_ticket_id'=>$this->integer(),
        ]);
        $this->alterColumn('users', 'role', "enum('" . User::ROLE_ADMIN . "','" . User::ROLE_PM . "','"
            . User::ROLE_DEV . "','" . User::ROLE_CLIENT . "','"
            . User::ROLE_FIN . "','" . User::ROLE_GUEST . "' ) NOT NULL DEFAULT '" . User::ROLE_DEV . "'");
    }

    public function safeDown()
    {
        echo "m160527_053653_table_support_tickets_support_ticket_comments cannot be reverted.\n";

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
