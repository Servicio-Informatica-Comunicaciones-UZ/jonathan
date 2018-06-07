<?php

namespace app\controllers\gestion;

use Yii;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use app\models\User;

/**
 * This is the class for controller "gestion/UserController".
 */
class UserController extends \app\controllers\base\AppController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['gestorMasters'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        return Yii::$app->getResponse()->redirect(['//saml/login']);
                    }
                    throw new ForbiddenHttpException(
                        Yii::t('app', 'No tiene permisos para acceder a esta página. 😨')
                    );
                },
            ],
        ];
    }

    /**
     * Crea un usuario y le asigna el rol indicado.
     */
    public function actionCrear($rol = 'evaluador')
    {
        if ('admin' == $rol or 'superadmin' == $rol) {
            Yii::$app->session->addFlash('danger', Yii::t('jonathan', '¡No puede asignar el rol de administrador!'));

            return $this->redirect(Yii::$app->request->referrer);
        }

        $model = new User();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $profile = $model->getProfile()->one();
                $profile->name = Yii::$app->request->post('Profile')['name'];
                $profile->gravatar_email = $model->email;
                // TODO: Extender el profile para guardar el colectivo, nombres y apellidos por separado, etc.
                $profile->save();

                $auth = Yii::$app->authManager;
                $rolModel = $auth->getRole($rol);
                $auth->assign($rolModel, $model->id);

                $transaction->commit();
                Yii::$app->session->addFlash('success', sprintf(Yii::t(
                    'jonathan',
                    "Se ha creado el usuario «%s».  Por favor, infórmele de su nombre de usuario y contraseña.\n"
                        . "Al tratarse de un usuario externo, para iniciar sesión deberá usar la dirección\n%s"
                ), $model->username, Url::toRoute('//user/login', true)));
                Yii::info(
                    sprintf(
                        '%s (%s) ha creado el usuario «%s» (%s) con rol «%s»',
                        Yii::$app->user->identity->username,
                        Yii::$app->user->identity->profile->name,
                        $model->username,
                        $model->getProfile()->one()->name,
                        $rol
                    ),
                    'gestion'
                );

                return $this->redirect(['listado', 'rol' => $rol]);
            } elseif (!\Yii::$app->request->isPost) {
                $model->load(Yii::$app->request->get());
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();
            $model->addError('_exception', $msg);
            $transaction->rollBack();
        }

        return $this->render('crear', ['model' => $model, 'rol' => $rol]);
    }

    /**
     * Muestra un listado de los usuarios que tienen un rol determinado.
     */
    public function actionListado($rol = 'evaluador')
    {
        $usuarios = User::find()->orderBy('username')->all();
        $usuarios_del_rol = array_filter($usuarios, function ($usuario) use ($rol) {
            return $usuario->hasRole($rol);
        });

        return $this->render('listado', ['rol' => $rol, 'usuarios' => $usuarios_del_rol]);
    }
}
