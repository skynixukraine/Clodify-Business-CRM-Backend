<?php
use yii\db\Migration;

class m161202_142913_cost_column_in_project_table extends Migration
{
    public function up()
    {
        $this->addColumn('projects', 'cost', $this->decimal(10,2)->defaultValue('0'));
		$this->db->createCommand('
			UPDATE projects p
			LEFT JOIN (SELECT
				reports.project_id prid,
				SUM(reports.hours * (users.salary / 168)) AS cost
			  FROM reports
				INNER JOIN projects
				  ON reports.project_id = projects.ID
				INNER JOIN users
				  ON reports.user_id = users.ID
			  WHERE reports.is_delete = 0
			  AND users.is_delete = 0
			  GROUP BY project_id) AS costs
			  ON p.ID = costs.prid
			SET p.cost = costs.cost')->execute();
    }
    public function down()
    {
        echo "m161202_142913_cost_column_in_project_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
