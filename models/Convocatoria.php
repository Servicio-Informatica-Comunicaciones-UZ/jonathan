<?php

namespace app\models;

use Yii;
use \app\models\base\Convocatoria as BaseConvocatoria;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "convocatoria".
 */
class Convocatoria extends BaseConvocatoria
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
