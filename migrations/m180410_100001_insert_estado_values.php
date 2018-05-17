<?php

use yii\db\Migration;

/**
 * Class m180515_073911_insert_estado_values
 */
class m180410_100001_insert_estado_values extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('estado', [
            'id' => 1,
            'nombre' => 'Borrador',
        ]);
        $this->insert('estado', [
            'id' => 2,
            'nombre' => 'Presentada',
        ]);
        /* Al añadir o modificar estados, actualizar las constantes del modelo Estado. */
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('estado', [
            'id' => 1,
        ]);
        $this->delete('estado', [
            'id' => 2,
        ]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180515_073911_insert_estado_values cannot be reverted.\n";

        return false;
    }
    */
}
