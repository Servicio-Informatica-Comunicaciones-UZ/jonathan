<?php

namespace app\controllers\gestion;

use Yii;
use yii\web\ForbiddenHttpException;
use app\models\Propuesta;
use app\models\PropuestaEvaluador;

/**
 * This is the class for controller "gestion/PropuestaEvaluadorController".
 */
class PropuestaEvaluadorController extends \app\controllers\base\PropuestaEvaluadorController
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
     * Muestra un listado de las asignaciones Propuesta ⟷ Evaluador.
     */
    public function actionListado($anyo)
    {
        $dpEvaluables = Propuesta::getDpEvaluables($anyo);

        return $this->render('listado', ['dpEvaluables' => $dpEvaluables]);
    }

    /**
     * Muestra la página para modificar los evaluadores de la propuesta indicada.
     */
    public function actionEditarEvaluadores($id)
    {
        $propuesta = Propuesta::findOne(['id' => $id]);
        $model = new PropuestaEvaluador();

        try {
            if ($model->load($_POST) && $model->save()) {
                return $this->redirect(['editar-evaluadores', 'id' => $id]);
            } elseif (!\Yii::$app->request->isPost) {
                $model->load($_GET);
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
            $model->addError('_exception', $msg);
        }

        return $this->render('editar-evaluadores', ['model' => $model, 'propuesta' => $propuesta]);
    }
}
