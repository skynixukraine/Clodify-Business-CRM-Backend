<?php

use yii\db\Migration;
use yii\db\Query;


/**
 * Class m180925_101326_add_invoice_increment_id
 */
class m180925_101326_add_invoice_increment_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = Yii::$app->db->schema->getTableSchema('busineses');
        if(!isset($table->columns['invoice_increment_id'])) {
            $this->addColumn('busineses', 'invoice_increment_id', $this->integer(11) . ' AFTER name');

            $busineses = (new Query())
                ->select('*')
                ->from('busineses')
                ->all();


            if(!empty($busineses)) {
                foreach($busineses as $elem) {
                    $this->update('busineses', ['invoice_increment_id' => $elem['id']], '1');
                }
            }
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180925_101326_add_invoice_increment_id cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180925_101326_add_invoice_increment_id cannot be reverted.\n";

        return false;
    }
    */
}
