<?php

namespace app\models;

use Yii;
use \app\models\base\Estado as BaseEstado;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "estado".
 */
class Estado extends BaseEstado
{
    // Valores definidos en m180410_100001_insert_estado_values
    const BORRADOR = 1;
    const PRESENTADA = 2;

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
