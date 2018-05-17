<?php

use yii\db\Migration;

/**
 * Handles the creation of table `propuesta_centro`.
 */
class m180412_123735_create_propuesta_centro_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('propuesta_centro', [
            'id' => $this->primaryKey(),
            'propuesta_id' => $this->integer(),
            'nombre_centro' => $this->string(250),
            'documento_firma' => $this->string(250),
        ]);
        $this->addForeignKey(
            'fk-propuesta_centro-propuesta_id',
            'propuesta_centro',
            'propuesta_id',
            'propuesta',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('propuesta_centro');
    }
}
