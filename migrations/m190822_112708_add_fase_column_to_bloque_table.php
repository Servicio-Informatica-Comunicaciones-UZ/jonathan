<?php

use yii\db\Migration;

/**
 * Handles adding fase to table `{{%bloque}}`.
 */
class m190822_112708_add_fase_column_to_bloque_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%bloque}}', 'fase', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%bloque}}', 'fase');
    }
}
