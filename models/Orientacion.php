<?php

namespace app\models;

use Yii;
use \app\models\base\Orientacion as BaseOrientacion;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "orientacion".
 */
class Orientacion extends BaseOrientacion
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
