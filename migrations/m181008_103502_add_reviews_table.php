<?php

use yii\db\Migration;

/**
 * Class m181008_103502_add_reviews_table
 */
class m181008_103502_add_reviews_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB';
        }

        $this->createTable('reviews', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'date_from' => $this->date(),
            'date_to' => $this->date(),
            'score_loyalty' => $this->integer()->defaultValue(0),
            'score_performance' => $this->integer()->defaultValue(0),
            'score_earnings' => $this->integer()->defaultValue(0),
            'score_total' => $this->integer()->defaultValue(0),
            'notes' => $this->text()

        ], $tableOptions);

        $this->addForeignKey(
            'fk_user_id',
            'reviews',
            'user_id',
            'users',
            'id',
            'CASCADE',
            'NO ACTION'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181008_103502_add_reviews_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181008_103502_add_reviews_table cannot be reverted.\n";

        return false;
    }
    */
}
