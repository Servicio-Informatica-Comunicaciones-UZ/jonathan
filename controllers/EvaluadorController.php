<?php

namespace app\controllers;

use Yii;
use yii\web\ForbiddenHttpException;
use app\models\Propuesta;
use app\models\PropuestaEvaluador;

/**
 * This is the class for controller "EvaluadorController".
 */
class EvaluadorController extends \app\controllers\base\AppController
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
     * Muestra la página principal de los evaluadores.
     */
    public function actionIndex()
    {
        $asignadasQuery = Propuesta::find()->delEvaluador(Yii::$app->user->id);

        $asignadasDataProvider = new \yii\data\ActiveDataProvider([
            'query' => $asignadasQuery,
            'pagination' => false,
            'sort' => [
                'attributes' => ['anyo', 'denominacion'],
                'defaultOrder' => [
                    'anyo' => SORT_DESC,
                    'denominacion' => SORT_ASC,
                ],
            ],
        ]);

        return $this->render('index', ['asignadasDataProvider' => $asignadasDataProvider]);
    }
}
