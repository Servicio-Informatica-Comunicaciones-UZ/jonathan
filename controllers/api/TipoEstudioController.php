<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "TipoEstudioController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class TipoEstudioController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\TipoEstudio';
}
