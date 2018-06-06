<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "BloqueController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class BloqueController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\Bloque';
}
