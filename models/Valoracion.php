<?php

namespace app\models;

use Yii;
use \app\models\base\Valoracion as BaseValoracion;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "valoracion".
 */
class Valoracion extends BaseValoracion
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
