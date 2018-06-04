<?php

use yii\db\Migration;

/**
 * Class m180604_124748_insert_estado_values
 */
class m180604_124748_insert_estado_values extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('estado', [
            'id' => 3,
            'nombre' => 'Aprobada internamente',
        ]);
        $this->insert('estado', [
            'id' => 4,
            'nombre' => 'Aprobada externamente',
        ]);
        $this->insert('estado', [
            'id' => 5,
            'nombre' => 'Rechazada externamente',
        ]);
        /* Al añadir o modificar estados, actualizar las constantes del modelo Estado. */
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180604_124748_insert_estado_values cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180604_124748_insert_estado_values cannot be reverted.\n";

        return false;
    }
    */
}
