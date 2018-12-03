<?php

 use app\components\SkynixMigration;

class m171019_070303_insert_into_settings_corpevents_and_bonuses extends SkynixMigration
{
    public function up()
    {
        $this->insert('settings', [
            'key' => 'corp_events_percentage',
            'value' => 10,
            'type' =>'INT'
        ]);


        $this->insert('settings', [
            'key' => 'bonuses_percentage',
            'value' => 10,
            'type' =>'INT'
        ]);
    }

    public function down()
    {
        echo "m171019_070303_insert_into_settings_corpevents_and_bonuses cannot be reverted.\n";

        return false;
    }
}
