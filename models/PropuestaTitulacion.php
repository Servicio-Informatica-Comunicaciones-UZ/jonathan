<?php

namespace app\models;

use Yii;
use \app\models\base\PropuestaTitulacion as BasePropuestaTitulacion;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "propuesta_titulacion".
 */
class PropuestaTitulacion extends BasePropuestaTitulacion
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
