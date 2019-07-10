<?php

use app\components\SkynixMigration;

/**
 * Class m190703_102632_add_encryption_key_setting
 */
class m190703_102632_add_encryption_key_setting extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $faker = Faker\Factory::create();

        $this->insert('settings', [
            'key' => 'encryption_key',
            'value' => password_hash($faker->regexify('[A-Za-z0-9]{20}'), PASSWORD_BCRYPT),
            'type' => 'STRING',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('settings', ['key' => 'encryption_key']);
    }
}
