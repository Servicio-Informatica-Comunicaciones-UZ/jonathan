<?php

namespace app\models;

use Yii;
use \app\models\base\Enlace as BaseEnlace;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "enlace".
 */
class Enlace extends BaseEnlace
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
