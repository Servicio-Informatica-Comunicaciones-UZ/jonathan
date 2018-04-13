<?php

use yii\db\Migration;

/**
 * Handles the creation of table `propuesta_doctorado`.
 */
class m180412_124858_create_propuesta_doctorado_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('propuesta_doctorado', [
            'id' => $this->primaryKey(),
            'propuesta_id' => $this->integer(),
            'nombre_doctorado' => $this->string(250),
        ]);
        $this->addForeignKey(
            'fk-propuesta_doctorado-propuesta_id',
            'propuesta_doctorado',
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
        $this->dropTable('propuesta_doctorado');
    }
}
