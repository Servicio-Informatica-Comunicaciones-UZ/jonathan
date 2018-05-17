<?php

use yii\db\Migration;

/**
 * Class m180410_090000_insert_tipo_estudio_values
 */
class m180410_090000_insert_tipo_estudio_values extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('tipo_estudio', [
            'id' => 5,
            'nombre' => 'Grado',
        ]);
        $this->insert('tipo_estudio', [
            'id' => 6,
            'nombre' => 'Máster',
        ]);
        $this->insert('tipo_estudio', [
            'id' => 7,
            'nombre' => 'Doctorado',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('tipo_estudio', [
            'id' => 5,
        ]);
        $this->delete('tipo_estudio', [
            'id' => 6,
        ]);
        $this->delete('tipo_estudio', [
            'id' => 7,
        ]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180410_074737_insert_tipo_estudio_values cannot be reverted.\n";

        return false;
    }
    */
}
