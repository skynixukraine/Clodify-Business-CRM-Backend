<?php

 use app\components\SkynixMigration;

class m170405_134435_create_table_candidates extends SkynixMigration
{
    /**
     * create table candidates
     */
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('candidates', [
            'id' => $this->primaryKey()->notNull() . ' AUTO_INCREMENT',
            'career_id' => $this->integer(),
            'first_name' => $this->string(150),
            'last_name' => $this->string(150),
            'email' => $this->string(200),
            'date_applied' => $this->timestamp()->defaultValue(null),
            'date_interview' => $this->timestamp()->defaultValue(null),
            'is_interviewed' => $this->boolean()->defaultValue(false),
            'skills' => $this->string(255),
            'backend_skills' => $this->integer()->defaultValue(0),
            'frontend_skills' => $this->integer()->defaultValue(0),
            'system_skills' => $this->integer()->defaultValue(0),
            'other_skills' => $this->integer()->defaultValue(0),
            'desired_salary' => $this->integer()->defaultValue(0),
            'interviewer_notes' => $this->text()
        ], $tableOptions);

        $this->addForeignKey(
            'fk-post-career_id',
            'candidates',
            'career_id',
            'careers',
            'id',
            'CASCADE'
        );
    }

    /**
     * drop table candidates
     */
    public function down()
    {
        $this->dropTable('candidates');

        $this->dropForeignKey(
            'fk-post-career_id',
            'candidates'
        );
    }

}
