<?php

use yii\db\Migration;

/**
 * Class m180412_111849_insert_modalidad_table.
 */
class m180412_111849_insert_modalidad_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('modalidad', [
            'nombre' => 'Presencial',
        ]);
        $this->insert('modalidad', [
            'nombre' => 'Semipresencial',
        ]);
        $this->insert('modalidad', [
            'nombre' => 'Online',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "to m180412_111849_insert_modalidad_table delete carefully table content.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180412_111849_insert_modalidad_table cannot be reverted.\n";

        return false;
    }
    */
}
