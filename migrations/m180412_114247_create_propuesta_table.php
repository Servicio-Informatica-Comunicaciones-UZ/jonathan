<?php

use yii\db\Migration;

/**
 * Handles the creation of table `propuesta`.
 */
class m180412_114247_create_propuesta_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('propuesta', [
            'id' => $this->primaryKey(),
            'nip' => $this->integer(),
            'denominacion' => $this->string(250),
            'orientacion_id' => $this->integer()->defaultValue(1),
            'creditos' => $this->integer(),
            'duracion' => $this->integer(),
            'modalidad_id' => $this->integer()->defaultValue(1),
            'plazas' => $this->integer(),
            'creditos_practicas' => $this->decimal(5,2),
            'tipo_estudio_id' => $this->integer(),
        ]);
        $this->addForeignKey(
            'fk-propuesta-orientacion_id',
            'propuesta',
            'orientacion_id',
            'orientacion',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-propuesta-modalidad_id',
            'propuesta',
            'modalidad_id',
            'modalidad',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-propuesta-tipo_estudio_id',
            'propuesta',
            'tipo_estudio_id',
            'tipo_estudio',
            'id',
            'CASCADE'
        );

        //TODO: FK del nip con la tabla de usuarios.
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('propuesta');
    }
}
