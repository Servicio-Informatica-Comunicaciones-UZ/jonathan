<?php

namespace app\controllers\gestion;

use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use app\models\Pregunta;
use app\models\Propuesta;
use app\models\Valoracion;

/**
 * This is the class for controller "gestion/ValoracionController".
 */
class ValoracionController extends \app\controllers\base\ValoracionController
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
     * Muestra una propuesta y sus valoraciones por el evaluador indicado.
     */
    public function actionVer($propuesta_id, $user_id)
    {
        Url::remember();
        $propuesta = Propuesta::getPropuesta($propuesta_id);
        $preguntas = Pregunta::find()->delAnyoYTipo($propuesta->anyo, $propuesta->tipo_estudio_id)->all();
        $respuestas = $propuesta->getRespuestas()->indexBy('pregunta_id')->all();
        $valoraciones = Valoracion::find()->deLaPropuesta($propuesta_id)->delEvaluador($user_id)->orderBy('bloque_id')->indexBy('bloque_id')->all();

        return $this->render('ver', [
            // 'bloques_autonomos' => Bloque::find()->where(['pregunta_id' => null])->all(),
            'propuesta' => $propuesta,
            'preguntas' => $preguntas,
            'respuestas' => $respuestas,
            'valoraciones' => $valoraciones,
        ]);
    }
}
