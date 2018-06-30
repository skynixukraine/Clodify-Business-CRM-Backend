<?php

use yii\db\Migration;

/**
 * Class m180629_093330_add_guest_role
 */
class m180629_093330_add_guest_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->alterColumn('users', 'role', "ENUM('ADMIN','PM','DEV','CLIENT','FIN','SALES', 'GUEST') NOT NULL DEFAULT '" . \app\models\User::ROLE_DEV . "'");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180629_093330_add_guest_role cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180629_093330_add_guest_role cannot be reverted.\n";

        return false;
    }
    */
}
