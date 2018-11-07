<?php


use app\components\SkynixMigration;


class m160504_151046_surveys extends SkynixMigration
{
    public function safeUp()
    {
        $this->createTable('surveys', [
           'id' => $this->primaryKey()->notNull() . ' AUTO_INCREMENT',
            'shortcode'     => 'varchar(25)',
            'question'      => 'varchar(25)',
            'description'   => $this->text(),
            'date_start'    => $this->dateTime(),
            'date_end'      =>  $this->dateTime(),
            'is_private'    =>  'tinyint(1)',
            'user_id'       =>  $this->integer(),
            'total_votes'   => $this->integer(11)
        ]);

    }

    public function safeDown()
    {
        echo "m160504_151046_surveys cannot be reverted.\n";

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
