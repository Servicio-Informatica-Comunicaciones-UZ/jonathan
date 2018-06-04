<?php

namespace app\controllers;

use Yii;
use yii\web\ForbiddenHttpException;
use app\models\Propuesta;

/**
 * This is the class for controller "GestionController".
 */
class GestionController extends \app\controllers\base\AppController
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
     * Muestra la página principal de gestión.
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
