<?php

namespace app\models;

use Yii;
use \app\models\base\PropuestaCentro as BasePropuestaCentro;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "propuesta_centro".
 */
class PropuestaCentro extends BasePropuestaCentro
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
