<?php

use yii\db\Migration;

/**
 * Class m190207_114052_add_row_to_estado_table
 */
class m190207_114052_add_row_to_estado_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('estado', [
            'id' => 9,
            'nombre' => 'Rechazada externamente',
        ]);
        /* Al añadir o modificar estados, actualizar las constantes del modelo Estado. */
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190207_114052_add_row_to_estado_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190207_114052_add_row_to_estado_table cannot be reverted.\n";

        return false;
    }
    */
}
