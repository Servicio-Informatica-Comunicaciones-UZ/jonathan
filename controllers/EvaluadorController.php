<?php

namespace app\controllers;

use Yii;
use yii\web\ForbiddenHttpException;

/**
 * This is the class for controller "EvaluadorController".
 */
class EvaluadorController extends \app\controllers\base\AppController
{
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
     * Muestra la página principal de los evaluadores.
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
