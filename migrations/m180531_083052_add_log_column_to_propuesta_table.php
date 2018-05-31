<?php

use yii\db\Migration;

/**
 * Handles adding log to table `propuesta`.
 */
class m180531_083052_add_log_column_to_propuesta_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('propuesta', 'log', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('propuesta', 'log');
    }
}
