<?php

namespace app\controllers\evaluador;

use Yii;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use app\models\Estado;
use app\models\PropuestaEvaluador;

/**
 * This is the class for controller "evaluador/PropuestaEvaluadorController".
 */
class PropuestaEvaluadorController extends \app\controllers\base\PropuestaEvaluadorController
{
    public $enableCsrfValidation = true;

    public function behaviors()
    {
        $id = Yii::$app->request->get('id');

        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) use ($id) {
                            $asignacion = $this->findModel($id);
                            return $asignacion->user_id === Yii::$app->user->id;
                        },
                        'roles' => ['evaluador'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        return Yii::$app->getResponse()->redirect(['//user/login']);
                    }
                    throw new ForbiddenHttpException(
                        Yii::t('app', 'No tiene permisos para acceder a esta página. 😨')
                    );
                },
            ],
        ];
    }

    /**
     * Presentación de la valoración de una propuesta.
     */
    public function actionPresentar($id)
    {
        $model = $this->findModel($id);
        $model->estado_id = Estado::VALORACION_PRESENTADA;
        $model->save();

        Yii::info(
            sprintf(
                '%s (%s) ha presentado su valoración de la propuesta %d (%s)',
                Yii::$app->user->identity->username,
                Yii::$app->user->identity->profile->name,
                $model->propuesta_id,
                $model->propuesta->denominacion
            ),
            'evaluador'
        );

        Yii::$app->session->addFlash(
            'success',
            Yii::t(
                'jonathan',
                'La valoración de la propuesta ha sido presentada correctamente.'
            )
        );

        return $this->redirect('@web/evaluador/index');
    }
}
