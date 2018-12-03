<?php

 use app\components\SkynixMigration;

/**
 * Handles the creation of table `auth_types`.
 */
class m180118_094617_create_auth_types_table extends SkynixMigration
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
        $this->createTable('auth_types', [
            'id' => $this->primaryKey(),
            'type_name'=> $this->string(255)
        ],$tableOptions);

        $this->insert('auth_types', [
            'type_name' => 'crowd_atlassian'
        ]);


        $this->insert('auth_types', [
            'type_name' => 'local_mysql'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('auth_types');
    }
}
