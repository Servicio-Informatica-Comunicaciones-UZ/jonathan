<?php

namespace app\controllers\evaluador;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use app\models\Bloque;
use app\models\Estado;
use app\models\Pregunta;
use app\models\Propuesta;
use app\models\PropuestaEvaluador;
use app\models\Valoracion;

/**
 * This is the class for controller "evaluador/PropuestaController".
 */
class PropuestaController extends \app\controllers\base\PropuestaController
{
    public $enableCsrfValidation = true;

    public function behaviors()
    {
        $propuesta_id = Yii::$app->request->get('propuesta_id');

        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['ver'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) use ($propuesta_id) {
                            $asignadas = PropuestaEvaluador::find()->select('propuesta_id')->delEvaluador(Yii::$app->user->id)->column();
                            return in_array($propuesta_id, $asignadas);
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
     * Muestra una propuesta y sus valoraciones por el usuario actual.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionVer($propuesta_id)
    {
        Url::remember();
        $propuesta = $this->findModel($propuesta_id);
        $preguntas = Pregunta::find()->delAnyoYTipo($propuesta->anyo, $propuesta->tipo_estudio_id)->deLaFase($propuesta->fase)->all();
        $respuestas = $propuesta->getRespuestas()->indexBy('pregunta_id')->all();
        $valoraciones = Valoracion::find()->deLaPropuesta($propuesta_id)->delEvaluador(Yii::$app->user->id)->all();

        return $this->render('ver', [
            'bloques_autonomos' => Bloque::find()->where(['pregunta_id' => null])->all(),
            'model' => $propuesta,
            'preguntas' => $preguntas,
            'respuestas' => $respuestas,
            'valoraciones' => $valoraciones,
        ]);
    }
}
