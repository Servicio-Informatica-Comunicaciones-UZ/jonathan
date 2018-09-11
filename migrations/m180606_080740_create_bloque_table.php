<?php

use yii\db\Migration;

/**
 * Handles the creation of table `bloque`.
 */
class m180606_080740_create_bloque_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('bloque', [
            'id' => $this->primaryKey(),
            'pregunta_id' => $this->integer(),
            'titulo' => $this->string(100),
            'descripcion' => $this->text(),
            'porcentaje' => $this->decimal(5, 2),
            'tiene_puntuacion_interna' => $this->boolean(),
        ]);
        $this->addForeignKey(
            'fk-bloque-pregunta_id',
            'bloque',
            'pregunta_id',
            'pregunta',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('bloque');
    }
}
