<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%convenio_intercambios}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%propuesta}}`
 */
class m190215_120343_create_convenio_intercambios_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%convenio_intercambios}}', [
            'id' => $this->primaryKey(),
            'propuesta_id' => $this->integer()->notNull(),
            'nombre_entidad' => $this->string(),
            'documento' => $this->string(),
        ]);

        // creates index for column `propuesta_id`
        $this->createIndex(
            '{{%idx-convenio_intercambios-propuesta_id}}',
            '{{%convenio_intercambios}}',
            'propuesta_id'
        );

        // add foreign key for table `{{%propuesta}}`
        $this->addForeignKey(
            '{{%fk-convenio_intercambios-propuesta_id}}',
            '{{%convenio_intercambios}}',
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
            '{{%fk-convenio_intercambios-propuesta_id}}',
            '{{%convenio_intercambios}}'
        );

        // drops index for column `propuesta_id`
        $this->dropIndex(
            '{{%idx-convenio_intercambios-propuesta_id}}',
            '{{%convenio_intercambios}}'
        );

        $this->dropTable('{{%convenio_intercambios}}');
    }
}
