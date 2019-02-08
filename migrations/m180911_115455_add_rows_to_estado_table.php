<?php

use yii\db\Migration;

/**
 * Class m180911_115455_add_rows_to_estado_table
 */
class m180911_115455_add_rows_to_estado_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('estado', [
            'id' => 6,
            'nombre' => 'Valoración pendiente',
        ]);
        $this->insert('estado', [
            'id' => 7,
            'nombre' => 'Valoración presentada',
        ]);
        $this->insert('estado', [
            'id' => 8,
            'nombre' => 'Fuera de plazo',
        ]);
        /* Al añadir o modificar estados, actualizar las constantes del modelo Estado. */
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('estado', [
            'id' => [6, 7, 8],
        ]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180911_115455_add_rows_to_estado_table cannot be reverted.\n";

        return false;
    }
    */
}
