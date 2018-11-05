<?php

 use app\components\SkynixMigration;

/**
 * Class m180626_185114_refactor_crowd_token
 */
class m180626_185114_refactor_crowd_token extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('access_keys');
        $this->addColumn('api_auth_access_tokens', 'crowd_exp_date', $this->integer(11));
        $this->addColumn('api_auth_access_tokens', 'crowd_token', $this->string(40));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180626_185114_refactor_crowd_token cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180626_185114_refactor_crowd_token cannot be reverted.\n";

        return false;
    }
    */
}
