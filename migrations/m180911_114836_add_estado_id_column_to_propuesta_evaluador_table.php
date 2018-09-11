<?php

use yii\db\Migration;

/**
 * Handles adding estado_id to table `propuesta_evaluador`.
 * Has foreign keys to the tables:
 *
 * - `estado`
 */
class m180911_114836_add_estado_id_column_to_propuesta_evaluador_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('propuesta_evaluador', 'estado_id', $this->integer());

        // creates index for column `estado_id`
        $this->createIndex(
            'idx-propuesta_evaluador-estado_id',
            'propuesta_evaluador',
            'estado_id'
        );

        // add foreign key for table `estado`
        $this->addForeignKey(
            'fk-propuesta_evaluador-estado_id',
            'propuesta_evaluador',
            'estado_id',
            'estado',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `estado`
        $this->dropForeignKey(
            'fk-propuesta_evaluador-estado_id',
            'propuesta_evaluador'
        );

        // drops index for column `estado_id`
        $this->dropIndex(
            'idx-propuesta_evaluador-estado_id',
            'propuesta_evaluador'
        );

        $this->dropColumn('propuesta_evaluador', 'estado_id');
    }
}
