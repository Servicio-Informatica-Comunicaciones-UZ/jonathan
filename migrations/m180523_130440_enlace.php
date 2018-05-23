<?php

use yii\db\Migration;

/**
 * Class m180523_130440_enlace
 */
class m180523_130440_enlace extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('enlace', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string(255),
            'uri' => $this->string(255),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('enlace');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180523_130440_enlace cannot be reverted.\n";

        return false;
    }
    */
}
