<?php

namespace app\controllers\gestion;

use Yii;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use app\models\Pregunta;
use app\models\Propuesta;

/**
 * This is the class for controller "gestion/PropuestaController".
 */
class PropuestaController extends \app\controllers\base\PropuestaController
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
     * Muestra un listado de las propuestas de un año que estén en un estado determinado.
     */
    public function actionListadoPropuestas($anyo, $estado_id)
    {
        $dpPropuestas = Propuesta::getDpPropuestasEnEstado($anyo, $estado_id);

        return $this->render('listado-propuestas', ['dpPropuestas' => $dpPropuestas, 'estado_id' => $estado_id]);
    }

    /**
     * Muestra una única propuesta.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionVer($id)
    {
        Url::remember();
        $propuesta = $this->findModel($id);
        $preguntas = Pregunta::find()
            ->where(['anyo' => $propuesta->anyo, 'tipo_estudio_id' => $propuesta->tipo_estudio_id])
            ->orderBy('orden')
            ->all();

        return $this->render('ver', [
            'model' => $propuesta,
            'preguntas' => $preguntas,
        ]);
    }
}
