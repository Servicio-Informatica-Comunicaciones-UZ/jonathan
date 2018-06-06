<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "ValoracionController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class ValoracionController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\Valoracion';
}
