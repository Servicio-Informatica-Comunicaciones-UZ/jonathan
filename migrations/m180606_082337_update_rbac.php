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

        // Add "evaluador" role and give this role the "valorar" permission
        $evaluador = $auth->createRole('evaluador');
        $evaluador->description = 'Usuarios evaluadores';
        $auth->add($evaluador);
        $auth->addChild($evaluador, $valorar);

        // Give the "admin" role the permissions of the "evaluador" role
        $admin = $auth->getRole('admin');
        $auth->addChild($admin, $evaluador);
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
