<?php

use yii\db\Migration;

/**
 * Handles adding fase to table `pregunta`.
 */
class m190208_072225_add_fase_column_to_pregunta_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('pregunta', 'fase', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('pregunta', 'fase');
    }
}
