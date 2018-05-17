<?php

namespace app\models;

use Yii;
use \app\models\base\Respuesta as BaseRespuesta;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "respuesta".
 */
class Respuesta extends BaseRespuesta
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }
}
