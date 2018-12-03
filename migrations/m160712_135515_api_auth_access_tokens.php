<?php



use app\components\SkynixMigration;


class m160712_135515_api_auth_access_tokens extends SkynixMigration
{
    public function up()
    {
        $this->createTable('api_auth_access_tokens', [
            'id' => $this->primaryKey()->notNull() . ' AUTO_INCREMENT',
            'user_id' => $this->integer(),
            'access_token' => $this->string(40)->notNull(),
            'exp_date'  => $this->dateTime(),
        ]);
    }

    public function down()
    {
        echo "m160712_135515_api_auth_access_tokens cannot be reverted.\n";

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
