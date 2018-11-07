<?php

 use app\components\SkynixMigration;

/**
 * Class m180415_063408_emergencies
 */
class m180415_063408_emergencies extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('emergencies', [
            'id'                => $this->primaryKey(),
            'user_id'           => $this->integer(),
            'date_registered'   => $this->integer(),
            'summary'           => $this->text(),
        ]);
        $this->addForeignKey(
            'fk_emergencies_users',
            'emergencies',
            'user_id',
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
        echo "m180415_063408_emergencies cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180415_063408_emergencies cannot be reverted.\n";

        return false;
    }
    */
}
