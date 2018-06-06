<?php

use yii\db\Migration;

/**
 * Handles the creation of table `valoracion`.
 */
class m180606_082025_create_valoracion_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('valoracion', [
            'id' => $this->primaryKey(),
            'propuesta_id' => $this->integer(),
            'bloque_id' => $this->integer(),
            'respuesta_id' => $this->integer(),
            'user_id' => $this->integer(),
            'comentarios' => $this->text(),
            'nota' => $this->decimal(5, 2),
        ]);
        $this->addForeignKey(
            'fk-valoracion-propuesta_id',
            'valoracion',
            'propuesta_id',
            'propuesta',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-valoracion-bloque_id',
            'valoracion',
            'bloque_id',
            'bloque',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-valoracion-respuesta_id',
            'valoracion',
            'respuesta_id',
            'respuesta',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-valoracion-user_id',
            'valoracion',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('valoracion');
    }
}
