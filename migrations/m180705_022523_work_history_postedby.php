<?php

use yii\db\Migration;

/**
 * Class m180705_022523_work_history_postedby
 */
class m180705_022523_work_history_postedby extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('work_history', 'added_by_user_id', $this->integer(11));
        $this->addForeignKey(
            'fk_work_history_postedby_users',
            'work_history',
            'added_by_user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180705_022523_work_history_postedby cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180705_022523_work_history_postedby cannot be reverted.\n";

        return false;
    }
    */
}
