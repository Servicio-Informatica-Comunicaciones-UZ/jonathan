<?php

namespace app\models;

use Yii;
use \app\models\base\PropuestaGrupoInves as BasePropuestaGrupoInves;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "propuesta_grupo_inves".
 */
class PropuestaGrupoInves extends BasePropuestaGrupoInves
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
