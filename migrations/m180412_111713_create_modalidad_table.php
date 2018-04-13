<?php

use yii\db\Migration;

/**
 * Handles the creation of table `modalidad`.
 */
class m180412_111713_create_modalidad_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('modalidad', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string(50),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('modalidad');
    }
}
