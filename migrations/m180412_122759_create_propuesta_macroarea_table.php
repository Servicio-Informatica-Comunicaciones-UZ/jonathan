<?php

use yii\db\Migration;

/**
 * Handles the creation of table `propuesta_macroarea`.
 */
class m180412_122759_create_propuesta_macroarea_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('propuesta_macroarea', [
            'id' => $this->primaryKey(),
            'propuesta_id' => $this->integer(),
            'macroarea_id' => $this->integer(),
        ]);
        $this->addForeignKey(
            'fk-propuesta_macroarea-propuesta_id',
            'propuesta_macroarea',
            'propuesta_id',
            'propuesta',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-propuesta_macroarea-macroarea_id',
            'propuesta_macroarea',
            'macroarea_id',
            'macroarea',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('propuesta_macroarea');
    }
}
