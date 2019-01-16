<?php
use app\components\SkynixMigration;

/**
 * Class m190116_104519_vacation_history_items_table
 */
class m190116_104519_vacation_history_items_table extends SkynixMigration
{

    /**
     *
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB';
        }

        $this->createTable('vacation_history_items', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'days' => $this->integer(),
            'date' => $this->date()
        ], $tableOptions);

        $this->addForeignKey(
            'fk_user_id1', 
            'vacation_history_items', 
            'user_id', 
            'users', 
            'id', 
            'CASCADE', 
            'NO ACTION'
        );
    }

    /**
     *
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('vacation_history_items');

        $this->dropForeignKey('vacation_history_items');
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
