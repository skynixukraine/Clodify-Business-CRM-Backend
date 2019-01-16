<?php

use app\components\SkynixMigration;

/**
 * Class m190116_121849_update_value_vacation_days
 */
class m190116_121849_update_value_vacation_days extends SkynixMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $list = \app\models\User::find()->all();
        
        if ( $list ) {
            
            foreach ( $list as $user ) {
                if (isset($user->date_signup)) {
                    $y                     = date('Y', strtotime($user->date_signup));
                    $vacationDays          = 0;
                    $vacationDaysAvailable = 0;
                    if (($y >= '2017')&&($y <= '2018')) {
                        $vacationDays = 10;
                    } elseif ($y >= '2019') {
                        $vacationDays = 10 - date('n', strtotime($user->date_signup));
                    } elseif ($y <= '2016') {
                        $vacationDays = 21;
                    }
                    if (($y >= '2017')&&($y <= '2019')) {
                        if ($user->email == 'vitalii@skynix.co') {
                            $vacationDaysAvailable = 14;
                        } elseif ($user->email == 'olha@skynix.co') {
                            $vacationDaysAvailable = 11;
                        } elseif ($user->email == 'nastyakachura@skynix.co') {
                            $vacationDaysAvailable = 11;
                        } elseif ($user->email == 'vlitwork@skynix.co') {
                            $vacationDaysAvailable = 11;
                        } elseif ($user->email == 'ant.nat@skynix.co') {
                            $vacationDaysAvailable = 10;
                        } elseif ($user->email == 'anton.matyunin@skynix.co') {
                            $vacationDaysAvailable = 9;
                        } elseif ($user->email == 'alex.griban@skynix.co') {
                            $vacationDaysAvailable = 18;
                        } elseif ($user->email == 'bilmak@skynix.co') {
                            $vacationDaysAvailable = 24;
                        } elseif ($user->email == 'bogdan.kushlyk@skynix.co') {
                            $vacationDaysAvailable = 11;
                        } elseif ($user->email == 'volodymyr.babak@skynix.co') {
                            $vacationDaysAvailable = 10;
                        } elseif ($user->email == 'maryna.skrypnyk@skynix.co') {
                            $vacationDaysAvailable = 10;
                        } elseif ($user->email == 'natalia.yakimenko@skynix.co') {
                            $vacationDaysAvailable = 15;
                        } elseif ($user->email == 'helena.sajuk@skynix.co') {
                            $vacationDaysAvailable = 18;
                        } elseif ($user->email == 'oleksii.lihachov@skynix.co') {
                            $vacationDaysAvailable = 13;
                        } elseif ($user->email == 'denis.bondaletov@skynix.co') {
                            $vacationDaysAvailable = 14;
                        } elseif ($user->email == 'maryna.zhezhel@skynix.co') {
                            $vacationDaysAvailable = 9;
                        } elseif ($user->email == 'nazar.lynovetsky@skynix.co') {
                            $vacationDaysAvailable = 12;
                        } elseif ($user->email == 'olha.volovyk@skynix.co') {
                            $vacationDaysAvailable = 10;
                        } elseif ($user->email == 'anatoly.novakovsky@skynix.co') {
                            $vacationDaysAvailable = 9;
                        }
                    } elseif ($y <= '2016') {
                        $addDays = 11;
                        if ($user->email == 'vitalii@skynix.co') {
                            $vacationDaysAvailable = 14 + $addDays;
                        } elseif ($user->email == 'olha@skynix.co') {
                            $vacationDaysAvailable = 11 + $addDays;
                        } elseif ($user->email == 'nastyakachura@skynix.co') {
                            $vacationDaysAvailable = 11 + $addDays;
                        } elseif ($user->email == 'vlitwork@skynix.co') {
                            $vacationDaysAvailable = 11 + $addDays;
                        } elseif ($user->email == 'ant.nat@skynix.co') {
                            $vacationDaysAvailable = 10 + $addDays;
                        } elseif ($user->email == 'anton.matyunin@skynix.co') {
                            $vacationDaysAvailable = 9 + $addDays;
                        } elseif ($user->email == 'alex.griban@skynix.co') {
                            $vacationDaysAvailable = 18 + $addDays;
                        } elseif ($user->email == 'bilmak@skynix.co') {
                            $vacationDaysAvailable = 24 + $addDays;
                        } elseif ($user->email == 'bogdan.kushlyk@skynix.co') {
                            $vacationDaysAvailable = 11 + $addDays;
                        } elseif ($user->email == 'volodymyr.babak@skynix.co') {
                            $vacationDaysAvailable = 10 + $addDays;
                        } elseif ($user->email == 'maryna.skrypnyk@skynix.co') {
                            $vacationDaysAvailable = 10 + $addDays;
                        } elseif ($user->email == 'natalia.yakimenko@skynix.co') {
                            $vacationDaysAvailable = 15 + $addDays;
                        } elseif ($user->email == 'helena.sajuk@skynix.co') {
                            $vacationDaysAvailable = 18 + $addDays;
                        } elseif ($user->email == 'oleksii.lihachov@skynix.co') {
                            $vacationDaysAvailable = 13 + $addDays;
                        } elseif ($user->email == 'denis.bondaletov@skynix.co') {
                            $vacationDaysAvailable = 14 + $addDays;
                        } elseif ($user->email == 'maryna.zhezhel@skynix.co') {
                            $vacationDaysAvailable = 9 + $addDays;
                        } elseif ($user->email == 'nazar.lynovetsky@skynix.co') {
                            $vacationDaysAvailable = 12 + $addDays;
                        } elseif ($user->email == 'olha.volovyk@skynix.co') {
                            $vacationDaysAvailable = 10 + $addDays;
                        } elseif ($user->email == 'anatoly.novakovsky@skynix.co') {
                            $vacationDaysAvailable = 9 + $addDays;
                        }
                    }
                    
                    $this->update(\app\models\User::tableName(), [
                        'vacation_days' => $vacationDays, 'vacation_days_available' => $vacationDaysAvailable
                    ], ['id' => $user->id]);
                }
                
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190116_121849_update_value_vacation_days cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190116_121849_update_value_vacation_days cannot be reverted.\n";

        return false;
    }
    */
}
