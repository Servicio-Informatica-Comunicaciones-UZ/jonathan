<?php

use yii\db\Migration;

/**
 * Handles the creation of table `estado`.
 */
class m180410_100000_create_estado_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('estado', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string(50),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('estado');
    }
}
