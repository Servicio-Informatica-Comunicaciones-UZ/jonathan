<?php

use yii\db\Migration;

/**
 * Handles the creation of table `respuesta`.
 */
class m180412_191337_create_respuesta_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('respuesta', [
            'id' => $this->primaryKey(),
            'propuesta_id' => $this->integer(),
            'pregunta_id' => $this->integer(),
            'valor' => $this->text(),
        ]);
        $this->addForeignKey(
            'fk-respuesta-propuesta_id',
            'respuesta',
            'propuesta_id',
            'propuesta',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-respuesta-pregunta_id',
            'respuesta',
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
        $this->dropTable('respuesta');
    }
}
