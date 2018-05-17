<?php

use yii\db\Migration;

/**
 * Class m180410_074737_insert_macroarea_values
 */
class m180410_074737_insert_macroarea_values extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('macroarea', [
            'id_nk' => 'H',
            'nombre' => 'Artes y Humanidades',
        ]);
        $this->insert('macroarea', [
            'id_nk' => 'J',
            'nombre' => 'Ciencias Sociales y Jurídicas',
        ]);
        $this->insert('macroarea', [
            'id_nk' => 'S',
            'nombre' => 'Ciencias de la Salud',
        ]);
        $this->insert('macroarea', [
            'id_nk' => 'T',
            'nombre' => 'Ingeniería y Arquitectura',
        ]);
        $this->insert('macroarea', [
            'id_nk' => 'X',
            'nombre' => 'Ciencias',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('macroarea', [
            'id_nk' => 'H',
        ]);
        $this->delete('macroarea', [
            'id_nk' => 'J',
        ]);
        $this->delete('macroarea', [
            'id_nk' => 'S',
        ]);
        $this->delete('macroarea', [
            'id_nk' => 'T',
        ]);
        $this->delete('macroarea', [
            'id_nk' => 'X',
        ]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180410_074737_insert_macroarea_values cannot be reverted.\n";

        return false;
    }
    */
}
