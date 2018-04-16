<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "PreguntaController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class PreguntaController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\Pregunta';
}
