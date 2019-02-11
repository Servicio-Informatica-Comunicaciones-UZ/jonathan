<?php

use yii\db\Migration;

/**
 * Class m190211_100149_insert_estado_values
 */
class m190211_100149_insert_estado_values extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('estado', [
            'id' => 10,
            'nombre' => 'Fuera de plazo (fase 2)',
        ]);
        $this->insert('estado', [
            'id' => 11,
            'nombre' => 'Presentada (fase 2)',
        ]);
        $this->insert('estado', [
            'id' => 12,
            'nombre' => 'Rechazada externamente (fase 2)',
        ]);
        $this->insert('estado', [
            'id' => 13,
            'nombre' => 'Aprobada externamente (fase 2)',
        ]);
        /* Al añadir o modificar estados, actualizar las constantes del modelo Estado. */
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('estado', ['id' => [10, 11, 12, 13]]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190211_100149_insert_estado_values cannot be reverted.\n";

        return false;
    }
    */
}
