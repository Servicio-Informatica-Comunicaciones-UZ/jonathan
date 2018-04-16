<?php

namespace app\models;

use Yii;
use \app\models\base\Modalidad as BaseModalidad;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "modalidad".
 */
class Modalidad extends BaseModalidad
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
