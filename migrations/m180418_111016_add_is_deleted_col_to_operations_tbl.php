<?php

use yii\db\Migration;

/**
 * Class m180418_111016_add_is_deleted_col_to_operations_tbl
 */
class m180418_111016_add_is_deleted_col_to_operations_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn( 'operations', 'is_deleted', $this->tinyInteger()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180418_111016_add_is_deleted_col_to_operations_tbl cannot be reverted.\n";

        return false;
    }
}
