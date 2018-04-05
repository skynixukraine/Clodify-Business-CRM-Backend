<?php

use yii\db\Migration;

/**
 * Class m180405_125642_create_availability_logs_tbl
 */
class m180405_125642_create_availability_logs_tbl extends Migration
{
    /**
     * {@inheritdoc}
     *
     */
    public function up()
    {
        $this->createTable('availability_logs', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'date' => $this->integer(),
            'is_available' => $this->boolean(),
        ]);

        // add foreign key for table `availability_logs`
        $this->addForeignKey(
            'fk_availability_logs_users',
            'availability_logs',
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
    public function down()
    {
        // drops foreign key for table reference_book
        $this->dropForeignKey(
            'fk_availability_logs_users',
            'availability_logs'
        );

        $this->dropTable('availability_logs');
    }
}
