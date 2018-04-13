<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tipo_estudio`.
 */
class m180410_080000_create_tipo_estudio_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tipo_estudio', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string(50),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tipo_estudio');
    }
}
