<?php

use app\components\SkynixMigration;

class m160204_083656_projects_id_AUTO_INCREMENT extends SkynixMigration
{
    public function safeUp()
    {
        // Сохраняем текущее значение и выключаем проверку
        $this->execute("SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;");

        $this->alterColumn('projects', 'id', 'int(11) NOT NULL AUTO_INCREMENT');
        // Восстанавливаем старое значение
        $this->execute("SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;");


    }

    public function down()
    {
        echo "m160204_083656_projects_id_AUTO_INCREMENT cannot be reverted.\n";

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
