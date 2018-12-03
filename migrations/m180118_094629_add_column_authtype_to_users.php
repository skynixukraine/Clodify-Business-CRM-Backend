<?php

 use app\components\SkynixMigration;

class m180118_094629_add_column_authtype_to_users extends SkynixMigration
{
    public function up()
    {
        $this->addColumn( 'users', 'auth_type', $this->integer()->defaultValue(1));

        // add foreign key for table `users`
        $this->addForeignKey(
            'fk_users_auth_type',
            'users',
            'auth_type',
            'auth_types',
            'id',
            'NO ACTION',
            'NO ACTION'
        );
    }

    public function down()
    {
        // drops foreign key for table users
        $this->dropForeignKey(
            'fk_users_auth_type',
            'users'
        );

        $this->dropColumn('users', 'auth_type');
    }
}
