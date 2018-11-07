<?php

 use app\components\SkynixMigration;

class m180302_085003_add_new_columns_to_businesses_tbl extends SkynixMigration
{
    public function up()
    {
        $this->addColumn( 'busineses', 'invoice_increment_id', $this->integer()->defaultValue(1));
        $this->addColumn( 'busineses', 'address', $this->string(255));
        $this->addColumn( 'busineses', 'represented_by',  $this->string(255));
        $this->addColumn( 'busineses', 'bank_information', $this->text());
        $this->addColumn( 'busineses', 'director_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn( 'busineses', 'invoice_increment_id');
        $this->dropColumn( 'busineses', 'address');
        $this->dropColumn( 'busineses', 'represented_by');
        $this->dropColumn( 'busineses', 'bank_information');
        $this->dropColumn( 'busineses', 'director_id');
    }
}
