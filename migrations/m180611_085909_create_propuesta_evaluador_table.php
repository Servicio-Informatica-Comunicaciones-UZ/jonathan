<?php

use yii\db\Migration;

/**
 * Handles the creation of table `propuesta_evaluador`.
 * Has foreign keys to the tables:.
 *
 * - `propuesta`
 * - `user`
 */
class m180611_085909_create_propuesta_evaluador_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('propuesta_evaluador', [
            'id' => $this->primaryKey(),
            'propuesta_id' => $this->integer(),
            'user_id' => $this->integer(),
        ]);

        // creates index for column `propuesta_id`
        $this->createIndex(
            'idx-propuesta_evaluador-propuesta_id',
            'propuesta_evaluador',
            'propuesta_id'
        );

        // add foreign key for table `propuesta`
        $this->addForeignKey(
            'fk-propuesta_evaluador-propuesta_id',
            'propuesta_evaluador',
            'propuesta_id',
            'propuesta',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx-propuesta_evaluador-user_id',
            'propuesta_evaluador',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-propuesta_evaluador-user_id',
            'propuesta_evaluador',
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
        // drops foreign key for table `propuesta`
        $this->dropForeignKey(
            'fk-propuesta_evaluador-propuesta_id',
            'propuesta_evaluador'
        );

        // drops index for column `propuesta_id`
        $this->dropIndex(
            'idx-propuesta_evaluador-propuesta_id',
            'propuesta_evaluador'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-propuesta_evaluador-user_id',
            'propuesta_evaluador'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-propuesta_evaluador-user_id',
            'propuesta_evaluador'
        );

        $this->dropTable('propuesta_evaluador');
    }
}
