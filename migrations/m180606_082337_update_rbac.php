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

        // Add "valorar" permission
        $valorar = $auth->createPermission('valorar');
        $valorar->description = 'Valorar propuestas';
        $auth->add($valorar);

        // Add "valorador" role and give this role the "valorar" permission
        $valorador = $auth->createRole('valorador');
        $valorador->description = 'Usuarios valoradores';
        $auth->add($valorador);
        $auth->addChild($valorador, $valorar);

        // Give the "admin" role the permissions of the "valorador" role
        $admin = $auth->getRole('admin');
        $auth->addChild($admin, $valorador);
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
