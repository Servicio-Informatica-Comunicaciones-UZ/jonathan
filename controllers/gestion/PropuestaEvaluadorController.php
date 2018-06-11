<?php

namespace app\controllers\gestion;

use Yii;
use yii\web\ForbiddenHttpException;
use app\models\Propuesta;

/**
 * This is the class for controller "gestion/PropuestaEvaluadorController".
 */
class PropuestaEvaluadorController extends \app\controllers\base\PropuestaEvaluadorController
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
     * Muestra un listado de las asignaciones Propuesta ⟷ Evaluador.
     */
    public function actionListado($anyo)
    {
        $dpEvaluables = Propuesta::getDpEvaluables($anyo);

        return $this->render('listado', ['dpEvaluables' => $dpEvaluables]);
    }

    public function actionEditarEvaluadores($id)
    {
        $propuesta = Propuesta::findOne(['id' => $id]);

        return $this->render('editar-evaluadores', ['propuesta' => $propuesta]);
    }
}
