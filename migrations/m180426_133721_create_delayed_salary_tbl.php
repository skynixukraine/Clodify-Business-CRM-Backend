<?php

use yii\db\Migration;

/**
 * Class m180426_133721_create_delayed_salary_tbl
 */
class m180426_133721_create_delayed_salary_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('delayed_salary', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'month' => $this->integer(),
            'value' => $this->integer(),
            'raised_by' => $this->integer(),
            'is_applied' => $this->tinyInteger()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('delayed_salary');
    }
}
