<?php

use yii\db\Migration;

/**
 * Class m180601_111553_init_rbac
 */
class m180601_111553_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // Add "gestionarMasters" permission
        $gestionarMasters = $auth->createPermission('gestionarMasters');
        $gestionarMasters->description = 'Gestionar propuestas de máster';
        $auth->add($gestionarMasters);

        // Add "gestorMasters" role and give this role the "gestionarMasters" permission
        $gestorMasters = $auth->createRole('gestorMasters');
        $gestorMasters->description = 'Usuarios gestores de los másters';
        $auth->add($gestorMasters);
        $auth->addChild($gestorMasters, $gestionarMasters);

        // Add "admin" role and give this role the permissions of the "gestorMasters" role
        $admin = $auth->createRole('admin');
        $admin->description = 'Usuarios administradores';
        $auth->add($admin);
        $auth->addChild($admin, $gestorMasters);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180601_111553_init_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180601_111553_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
