<?php

use yii\db\Migration;

class m180328_111012_create_fixed_assets_operations_tbl extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('fixed_assets_operations', [
            'fixed_asset_id' => $this->integer()->notNull(),
            'operation_id' => $this->integer()->notNull(),
            'operation_business_id' => $this->integer()->notNull(),
            'PRIMARY KEY(fixed_asset_id, operation_id, operation_business_id)',
        ],$tableOptions);

        // creates index for columns 'operation_id', 'operation_business_id'
        $this->createIndex(
            'fk_fixed_assets_operations_operations1_idx',
            'fixed_assets_operations',
              ['operation_id', 'operation_business_id']
        );

        // add foreign key for table 'fixed_assets_operations'
        $this->addForeignKey(
            'fk_fixed_assets_operations_fixed_assets1',
            'fixed_assets_operations',
            'fixed_asset_id',
            'fixed_assets',
            'id',
            'NO ACTION',
            'NO ACTION'
        );

        // add foreign key for table 'fixed_assets_operations'
        $this->addForeignKey(
            'fk_fixed_assets_operations_operations1',
            'fixed_assets_operations',
            ['operation_id', 'operation_business_id'],
            'operations',
            ['id' , 'business_id'],
            'NO ACTION',
            'NO ACTION'
        );
    }

    public function down()
    {
        echo "m180328_111012_create_fixed_assets_operations_tbl cannot be reverted.\n";

        return false;
    }
}
