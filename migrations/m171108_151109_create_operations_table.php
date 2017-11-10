<?php

use yii\db\Migration;

/**
 * Handles the creation of table `operations`.
 */
class m171108_151109_create_operations_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableSchema = Yii::$app->db->schema->getTableSchema('operations');
        $tableOptions = null;

        if ($tableSchema === null) {
            if ($this->db->driverName === 'mysql') {
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable('operations', [
                'id' => $this->integer(),
                'business_id' => $this->integer(),
                'name' => $this->string(255),
                'status' => "enum('DONE', 'CANCELED')",
                'date_created' => $this->integer(),
                'date_updated' => $this->integer(),
                'operation_type_id' => $this->integer()->notNull(),
                'PRIMARY KEY(id, business_id)',
            ], $tableOptions);

            // creates index for column `business_id`
            $this->createIndex(
                'fk_operations_busineses1_idx',
                'operations',
                'business_id'
            );

            // add foreign key for table `busineses`
            $this->addForeignKey(
                'fk_operations_busineses1',
                'operations',
                'business_id',
                'busineses',
                'id',
                'NO ACTION',
                'NO ACTION'
            );

            // creates index for column `operation_type_id`
            $this->createIndex(
                'fk_operations_operation_types1_idx',
                'operations',
                'operation_type_id'
            );

            // add foreign key for table `operation_types`
            $this->addForeignKey(
                'fk_operations_operation_types1',
                'operations',
                'operation_type_id',
                'operation_types',
                'id',
                'NO ACTION',
                'NO ACTION'
            );
        }
    }

    public function safeDown()
    {
        // drops foreign key for table `operations`
        $this->dropForeignKey(
            'fk_operations_busineses1',
            'operations'
        );

        // drops index for column `business_id`
        $this->dropIndex(
            'fk_operations_busineses1_idx',
            'operations'
        );

        // drops foreign key for table `operation_types`
        $this->dropForeignKey(
            'fk_operations_operation_types1',
            'operations'
        );

        // drops index for column `operation_type_id`
        $this->dropIndex(
            'fk_operations_operation_types1_idx',
            'operations'
        );

        $this->dropTable('operations');
    }
}
