<?php

use yii\db\Migration;

/**
 * Handles the creation of table `propuesta_grupo_inves`.
 */
class m180412_124948_create_propuesta_grupo_inves_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('propuesta_grupo_inves', [
            'id' => $this->primaryKey(),
            'propuesta_id' => $this->integer(),
            'nombre_grupo_inves' => $this->string(250),
            'documento_firma' => $this->string(250),
        ]);
        $this->addForeignKey(
            'fk-propuesta_grupo_inves-propuesta_id',
            'propuesta_grupo_inves',
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
        $this->dropTable('propuesta_grupo_inves');
    }
}
