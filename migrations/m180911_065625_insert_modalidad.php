<?php

use yii\db\Migration;

/**
 * Class m180911_065625_insert_modalidad
 */
class m180911_065625_insert_modalidad extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('modalidad', [
            'id' => 4,
            'nombre' => 'Presencial + Semipresencial',
        ]);

        $this->insert('modalidad', [
            'id' => 5,
            'nombre' => 'Presencial + Online',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180911_065625_insert_modalidad cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180911_065625_insert_modalidad cannot be reverted.\n";

        return false;
    }
    */
}
