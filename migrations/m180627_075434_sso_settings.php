<?php

 use app\components\SkynixMigration;

/**
 * Class m180627_075434_sso_settings
 */
class m180627_075434_sso_settings extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('settings', 'value', $this->string(250));
        $this->insert('settings', [
            'key'       => \app\models\Setting::SSO_COOKIE_COMAIN_NAME,
            'value'     => 'crowd.token_key',
            'type'      => 'string'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180627_075434_sso_settings cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180627_075434_sso_settings cannot be reverted.\n";

        return false;
    }
    */
}
