<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%convenio_practicas}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%propuesta}}`
 */
class m190215_120159_create_convenio_practicas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%convenio_practicas}}', [
            'id' => $this->primaryKey(),
            'propuesta_id' => $this->integer()->notNull(),
            'nombre_entidad' => $this->string(),
            'documento' => $this->string(),
        ]);

        // creates index for column `propuesta_id`
        $this->createIndex(
            '{{%idx-convenio_practicas-propuesta_id}}',
            '{{%convenio_practicas}}',
            'propuesta_id'
        );

        // add foreign key for table `{{%propuesta}}`
        $this->addForeignKey(
            '{{%fk-convenio_practicas-propuesta_id}}',
            '{{%convenio_practicas}}',
            'propuesta_id',
            '{{%propuesta}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%propuesta}}`
        $this->dropForeignKey(
            '{{%fk-convenio_practicas-propuesta_id}}',
            '{{%convenio_practicas}}'
        );

        // drops index for column `propuesta_id`
        $this->dropIndex(
            '{{%idx-convenio_practicas-propuesta_id}}',
            '{{%convenio_practicas}}'
        );

        $this->dropTable('{{%convenio_practicas}}');
    }
}
