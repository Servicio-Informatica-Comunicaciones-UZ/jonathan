<?php

use yii\db\Migration;

/**
 * Handles the creation of table `pregunta`.
 */
class m180412_185540_create_pregunta_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('pregunta', [
            'id' => $this->primaryKey(),
            'anyo' => $this->integer(),
            'titulo' => $this->string(100),
            'descripcion' => $this->text(),
            'max_longitud' => $this->integer(),
            'orden' => $this->integer(),
            'tipo_estudio_id' => $this->integer(),
        ]);
        $this->addForeignKey(
            'fk-pregunta-tipo_estudio_id',
            'pregunta',
            'tipo_estudio_id',
            'tipo_estudio',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('pregunta');
    }
}
