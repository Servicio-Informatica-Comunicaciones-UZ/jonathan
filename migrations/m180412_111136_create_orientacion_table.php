<?php

use yii\db\Migration;

/**
 * Handles the creation of table `orientacion`.
 */
class m180412_111136_create_orientacion_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('orientacion', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string(50),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('orientacion');
    }
}
