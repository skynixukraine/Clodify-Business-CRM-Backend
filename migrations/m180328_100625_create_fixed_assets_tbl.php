<?php

use yii\db\Migration;

class m180328_100625_create_fixed_assets_tbl extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('fixed_assets', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'cost' =>  $this->float(),
            'inventory_number' => $this->integer(),
            'amortization_method' => "enum('LINEAR', '50/50') DEFAULT 'LINEAR'",
            'date_of_purchase' => $this->date(),
            'date_write_off' => $this->date()
        ],$tableOptions);
    }

    public function down()
    {
        echo "m180328_100625_create_fixed_assets_tbl cannot be reverted.\n";

        return false;
    }
}
