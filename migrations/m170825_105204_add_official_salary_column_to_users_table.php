<?php

use yii\db\Migration;

/**
 * Handles adding official_salary to table `users`.
 */
class m170825_105204_add_official_salary_column_to_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $usersTable = Yii::$app->db->schema->getTableSchema('users');

        if ($usersTable && !isset($usersTable->columns['official_salary'])) {
            $this->addColumn('users', 'official_salary', $this->double() . ' AFTER salary');
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('users', 'official_salary');
    }
}
