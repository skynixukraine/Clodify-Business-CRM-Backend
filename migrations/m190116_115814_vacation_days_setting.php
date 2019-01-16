<?php

use app\components\SkynixMigration;

/**
 * Class m190116_115814_vacation_days_setting
 */
class m190116_115814_vacation_days_setting extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('settings', [
            'key'       => \app\models\Setting::VACATION_DAYS,
            'value'     => 10,
            'type'      => 'INT'
        ]);
        $this->insert('settings', [
            'key'       => \app\models\Setting::VACATION_DAYS_UPGRADE_YEARS,
            'value'     => 3,
            'type'      => 'INT'
        ]);
        $this->insert('settings', [
            'key'       => \app\models\Setting::VACATION_DAYS_UPGRADED,
            'value'     => 21,
            'type'      => 'INT'
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190116_115814_vacation_days_setting cannot be reverted.\n";
        
        return false;
    }
    
    /*
     // Use up()/down() to run migration code without a transaction.
     public function up()
     {
     
     }
     
     public function down()
     {
     echo "m190116_115814_vacation_days_setting cannot be reverted.\n";
     
     return false;
     }
     */
}
