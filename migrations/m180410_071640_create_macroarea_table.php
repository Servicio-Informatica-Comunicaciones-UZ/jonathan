<?php

use yii\db\Migration;

/**
 * Handles the creation of table `macroarea`.
 */
class m180410_071640_create_macroarea_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('macroarea', [
            'id' => $this->primaryKey(),
            'id_nk' => $this->string(1), //Not used in this application. Only for integration with other systems
            'nombre' => $this->string(50),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('macroarea');
    }
}
