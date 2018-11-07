<?php

 use app\components\SkynixMigration;

/**
 * Class m180418_152343_add_new_operation_types
 */
class m180418_152343_add_new_operation_types extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->insert('operation_types', [
            'name' => 'Реалізація послуг',
        ]);
        $this->insert('operation_types', [
            'name' => 'Надходження товарів (послуг)',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->delete('operation_types', ['name' => 'Реалізація послуг']);
        $this->delete('operation_types', ['name' => 'Надходження товарів (послуг)']);
    }
}
