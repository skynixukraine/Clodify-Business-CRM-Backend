<?php

use yii\db\Migration;

class m170405_133928_create_table_careers extends Migration
{
    /**
     * create table careers
     */
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('careers', [
            'id' => $this->primaryKey()->notNull() . ' AUTO_INCREMENT',
            'title' => $this->string(255),
            'description' => $this->text(),
            'is_active' => $this->boolean()->defaultValue(false)
        ], $tableOptions);
    }

    /**
     * drop table careers
     */
    public function down()
    {
        $this->dropTable('careers');
    }

}
