<?php
/**
 * Controlador para establecer el idioma de la aplicación.
 *
 * @author  Enrique Matías Sánchez <quique@unizar.es>
 * @license GPL-3.0+
 */

namespace app\controllers;

use yii\web\Controller;
use Yii;

/**
 * This is the class for controller "LanguageController".
 */
class LanguageController extends Controller
{
    public $enableCsrfValidation = true;

    public function actionSet($language)
    {
        // Get the cookie collection from the "response" component
        $cookies = Yii::$app->response->cookies;

        // Add a new cookie to the response to be sent
        $cookies->add(new \yii\web\Cookie([
            'name' => 'language',
            'value' => preg_replace('/[^a-z_A-Z\.0-9\-]/', '', $language),
        ]));

        return $this->redirect(Yii::$app->request->referrer);
    }
}
