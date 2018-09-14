<?php

namespace app\controllers\gestion;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use yii\web\UnprocessableEntityHttpException;
use Da\User\Model\Profile;
use app\models\User;

/**
 * This is the class for controller "gestion/UserController".
 */
class UserController extends \app\controllers\base\AppController
{
    public $enableCsrfValidation = true;

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
     * Asigna un rol a un usuario.  Si no existe, lo crea.
     */
    public function actionAsignarRol($rol = 'evaluador')
    {
        if ('admin' == $rol or 'superadmin' == $rol) {
            Yii::$app->session->addFlash('danger', Yii::t('jonathan', '¡No puede asignar el rol de administrador!'));

            return $this->redirect(Yii::$app->request->referrer);
        }

        $request = Yii::$app->request;
        if ($request->isPost) {
            $nip = $request->post('nip');
            $usuario = User::findByUsername($nip);

            if (!$usuario) {
                $usuario = new User(
                    [
                    'username' => $nip,
                    'email' => "{$nip}@unizar.es",  // restricción UNIQUE
                    'password_hash' => "{$rol}",  // restricción NOT NULL
                    ]
                );
                $usuario->save();

                $identidad = User::findIdentidadByNip($nip);
                if (!$identidad) {
                    throw new UnprocessableEntityHttpException(
                        sprintf(Yii::t('gestion', 'No se ha encontrado el NIP «%d» en Gestión de Identidades. 😨'), $nip)
                    );
                }
                if (isset($identidad['CORREO_PRINCIPAL'])) {
                    $usuario->email = $identidad['CORREO_PRINCIPAL'];
                    $usuario->save();
                }

                $profile = $usuario->getProfile()->one();
                $profile->name = "{$identidad['NOMBRE']} {$identidad['APELLIDO_1']} {$identidad['APELLIDO_2']}";
                $profile->gravatar_email = $usuario->email;
                // TODO: Extender el profile para guardar el colectivo, nombres y apellidos por separado, etc.
                $profile->save();
            }

            if ($usuario->hasRole($rol)) {
                throw new UnprocessableEntityHttpException(
                    sprintf(Yii::t('gestion', 'El usuario «%d» ya tenía el rol «%s». 😨'), $nip, $rol)
                );
            }

            $auth = Yii::$app->authManager;
            $rolModel = $auth->getRole($rol);
            if (!$rolModel) {
                throw new UnprocessableEntityHttpException(
                    sprintf(Yii::t('gestion', 'El rol «%s» no existe. 😨'), $rol)
                );
            }
            $auth->assign($rolModel, $usuario->id);

            Yii::$app->session->addFlash(
                'success',
                sprintf(
                    Yii::t(
                        'jonathan',
                        'Se ha asignado el rol «%s» al usuario «%s».'
                    ),
                    $rol,
                    Html::encode($usuario->getProfile()->one()->name)
                )
            );
            Yii::info(
                sprintf(
                    '%s (%s) ha creado el usuario «%s» (%s) con rol «%s»',
                    Yii::$app->user->identity->username,
                    Yii::$app->user->identity->profile->name,
                    $usuario->username,
                    $usuario->getProfile()->one()->name,
                    $rol
                ),
                'gestion'
            );

            return $this->redirect(['listado', 'rol' => $rol]);
        }

        return $this->render('asignar-rol', ['rol' => $rol]);
    }

    /**
     * Crea un usuario local y le asigna el rol indicado.
     */
    public function actionCrearLocal($rol = 'evaluador')
    {
        if ('admin' == $rol or 'superadmin' == $rol) {
            Yii::$app->session->addFlash('danger', Yii::t('jonathan', '¡No puede asignar el rol de administrador!'));

            return $this->redirect(Yii::$app->request->referrer);
        }

        $model = new User();
        $model->setScenario('create');
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
                Yii::$app->session->addFlash(
                    'success',
                    sprintf(
                        Yii::t(
                            'jonathan',
                            "Se ha creado el usuario «%s».  Por favor, infórmele de su nombre de usuario y contraseña.\n"
                            ."Al tratarse de un usuario externo, para iniciar sesión deberá usar la dirección\n%s"
                        ),
                        Html::encode($model->username),
                        Url::toRoute('//user/login', true)
                    )
                );
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

        return $this->render('crear-local', ['model' => $model, 'rol' => $rol]);
    }

    /**
     * Quita un rol a un usuario.
     */
    public function actionQuitarRol($user_id, $rol)
    {
        if ('admin' == $rol or 'superadmin' == $rol) {
            Yii::$app->session->addFlash('danger', Yii::t('jonathan', '¡No puede quitar el rol de administrador!'));

            return $this->redirect(Yii::$app->request->referrer);
        }

        try {
            $model = User::getModel($user_id);
            $auth = Yii::$app->authManager;
            $rolModel = $auth->getRole($rol);
            if (!$rolModel) {
                throw new UnprocessableEntityHttpException(
                    sprintf(Yii::t('gestion', 'El rol «%s» no existe. 😨'), $rol)
                );
            }
            $auth->revoke($rolModel, $model->id);

            Yii::$app->session->addFlash(
                'success',
                sprintf(Yii::t('gestion', '%s ya no tiene el rol «%s».'), $model->profile->name, $rol)
            );
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();
            Yii::$app->getSession()->addFlash('error', $msg);

            return $this->redirect(Url::previous());
        }

        return $this->redirect(['//gestion/user/listado', 'rol' => $rol]);
    }

    /**
     * Muestra un listado de los usuarios que tienen un rol determinado.
     */
    public function actionListado($rol = 'evaluador')
    {
        Url::remember();
        $usuariosIds = Yii::$app->authManager->getUserIdsByRole($rol);
        // $usuarios = array_map('\app\models\User::getModel', $usuariosIds);
        $usuarios = User::find()->where(['id' => $usuariosIds])->orderBy('username')->all();

        return $this->render('listado', ['rol' => $rol, 'usuarios' => $usuarios]);
    }
}
