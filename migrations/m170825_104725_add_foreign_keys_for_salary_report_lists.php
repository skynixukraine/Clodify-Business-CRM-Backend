<?php

 use app\components\SkynixMigration;
use app\models\SalaryReportList;
use app\models\User;
use app\models\SalaryReport;

class m170825_104725_add_foreign_keys_for_salary_report_lists extends SkynixMigration
{
    public function safeUp()
    {

        $this->createIndex(
            'idx-salary_report_lists-user_id',
            SalaryReportList::tableName(),
            'user_id'
        );

        $this->addForeignKey(
            'fk-salary_report_lists-user_id',
            SalaryReportList::tableName(),
            'user_id',
            User::tableName(),
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-salary_report_lists-salary_report_id',
            SalaryReportList::tableName(),
            'salary_report_id'
        );

        $this->addForeignKey(
            'fk-salary_report_lists-salary_report_id',
            SalaryReportList::tableName(),
            'salary_report_id',
            SalaryReport::tableName(),
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-salary_report_lists-salary_report_id',
            SalaryReportList::tableName()
        );

        // drops index for column `salary_report_id`
        $this->dropIndex(
            'idx-salary_report_lists-salary_report_id',
            SalaryReportList::tableName()
        );

       $this->dropForeignKey(
            'fk-salary_report_lists-user_id',
            SalaryReportList::tableName()
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-salary_report_lists-user_id',
            SalaryReportList::tableName()
        );
    }

}
