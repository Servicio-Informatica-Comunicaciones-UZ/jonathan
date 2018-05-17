<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "RespuestaController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class RespuestaController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\Respuesta';
}
