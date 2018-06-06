<?php

use yii\db\Migration;

/**
 * Class m180606_082337_update_rbac
 */
class m180606_082337_update_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // Add "valorador" role
        $valorador = $auth->createRole('valorador');
        $valorador->description = 'Usuarios valoradores';
        $auth->add($valorador);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180606_082337_update_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180606_082337_update_rbac cannot be reverted.\n";

        return false;
    }
    */
}
