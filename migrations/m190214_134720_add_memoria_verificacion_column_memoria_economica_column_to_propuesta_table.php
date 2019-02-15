<?php

use yii\db\Migration;

/**
 * Handles adding memoria_verificacion_column_memoria_economica to table `{{%propuesta}}`.
 */
class m190214_134720_add_memoria_verificacion_column_memoria_economica_column_to_propuesta_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%propuesta}}', 'memoria_verificacion', $this->string()->after('estado_id'));
        $this->addColumn('{{%propuesta}}', 'memoria_economica', $this->string()->after('memoria_verificacion'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%propuesta}}', 'memoria_verificacion');
        $this->dropColumn('{{%propuesta}}', 'memoria_economica');
    }
}
