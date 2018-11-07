<?php

 use app\components\SkynixMigration;

/**
 * Handles the creation of table `work_history`.
 */
class m170419_095059_create_work_history_table extends SkynixMigration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('work_history', [
            'id' => $this->primaryKey()->notNull() . ' AUTO_INCREMENT',
            'user_id' => $this->integer(),
            'date_start' => $this->timestamp()->defaultValue(null),
            'date_end' => $this->timestamp()->defaultValue(null),
            'type' => $this->string(255),
            'title' => $this->string(255),
        ], $tableOptions);

        $this->addForeignKey(
            'fk_work_history_users',
            'work_history',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('work_history');

        $this->dropForeignKey(
            'fk_work_history_users',
            'work_history'
        );
    }

}
