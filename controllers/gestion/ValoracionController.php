<?php

namespace app\controllers\gestion;

use Yii;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use app\models\Bloque;
use app\models\Estado;
use app\models\Pregunta;
use app\models\Propuesta;
use app\models\PropuestaEvaluador;
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
        $asignacion = PropuestaEvaluador::find()->where(['propuesta_id' => $propuesta_id, 'user_id' => $user_id])->one();
        $propuesta = Propuesta::getPropuesta($propuesta_id);
        $preguntas = Pregunta::find()->delAnyoYTipo($propuesta->anyo, $propuesta->tipo_estudio_id)->deLaFase($propuesta->fase)->all();
        $respuestas = $propuesta->getRespuestas()->indexBy('pregunta_id')->all();
        $valoraciones = Valoracion::find()->deLaPropuesta($propuesta_id)->delEvaluador($user_id)->orderBy('bloque_id')->indexBy('bloque_id')->all();

        return $this->render('ver', [
            'asignacion' => $asignacion,
            'propuesta' => $propuesta,
            'preguntas' => $preguntas,
            'respuestas' => $respuestas,
            'valoraciones' => $valoraciones,
        ]);
    }

    /**
     * Muestra las puntuaciones de todas las propuestas de un año.
     */
    public function actionResumen($anyo = null)
    {
        $anyo_academico = date('m') < 10 ? date('Y') - 1 : date('Y');
        $anyo = $anyo ?: $anyo_academico;

        $bloques = Bloque::find()->joinWith('pregunta')->where(['pregunta.anyo' => $anyo])->orderBy('pregunta.orden')->all();
        $valoraciones = Valoracion::find()
            ->joinWith('propuesta')
            ->innerJoin('propuesta_evaluador', 'valoracion.user_id = propuesta_evaluador.user_id AND valoracion.propuesta_id = propuesta_evaluador.propuesta_id')
            ->where(['propuesta.anyo' => $anyo, 'propuesta_evaluador.estado_id' => Estado::VALORACION_PRESENTADA])
            ->orderBy('propuesta.denominacion, bloque_id, valoracion.user_id')
            //->createCommand()->getRawSql();
            ->all();

        $propuestas = [];
        foreach ($valoraciones as $valoracion) {
            $propuestas[$valoracion->propuesta_id][$valoracion->bloque_id][$valoracion->user_id] = $valoracion;
        }

        return $this->render('resumen', ['bloques' => $bloques, 'propuestas' => $propuestas]);
    }
}
