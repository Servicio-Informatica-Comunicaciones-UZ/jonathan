<?php

use yii\db\Migration;

/**
 * Handles adding fase to table `{{%propuesta_evaluador}}`.
 */
class m190218_081005_add_fase_column_to_propuesta_evaluador_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%propuesta_evaluador}}', 'fase', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%propuesta_evaluador}}', 'fase');
    }
}
