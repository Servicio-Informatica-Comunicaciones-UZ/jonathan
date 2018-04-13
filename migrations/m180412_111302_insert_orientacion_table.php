<?php

use yii\db\Migration;

/**
 * Class m180412_111302_insert_orientacion_table
 */
class m180412_111302_insert_orientacion_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('orientacion', [
            'id' => 1,
            'nombre' => null,
        ]);
        $this->insert('orientacion', [
            'nombre' => 'Profesional',
        ]);
        $this->insert('orientacion', [
            'nombre' => 'Investigación',
        ]);
        $this->insert('orientacion', [
            'nombre' => 'Mixto',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        echo "to revert m180412_111302_insert_orientacion_table delete carefully table content.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180412_111302_insert_orientacion_table cannot be reverted.\n";

        return false;
    }
    */
}
