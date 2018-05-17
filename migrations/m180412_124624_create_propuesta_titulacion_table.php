<?php

use yii\db\Migration;

/**
 * Handles the creation of table `propuesta_titulacion`.
 */
class m180412_124624_create_propuesta_titulacion_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('propuesta_titulacion', [
            'id' => $this->primaryKey(),
            'propuesta_id' => $this->integer(),
            'nombre_titulacion' => $this->string(250),
        ]);
        $this->addForeignKey(
            'fk-propuesta_titulacion-propuesta_id',
            'propuesta_titulacion',
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
        $this->dropTable('propuesta_titulacion');
    }
}
