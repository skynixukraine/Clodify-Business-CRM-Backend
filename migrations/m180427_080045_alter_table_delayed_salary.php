<?php

 use app\components\SkynixMigration;

/**
 * Class m180427_080045_alter_table_delayed_salary
 */
class m180427_080045_alter_table_delayed_salary extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->alterColumn('delayed_salary', 'is_applied', $this->integer(11).'DEFAULT 0');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "m180427_080045_alter_table_delayed_salary cannot be reverted.\n";

        return false;
    }

}
