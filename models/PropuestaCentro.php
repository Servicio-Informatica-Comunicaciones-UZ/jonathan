<?php

namespace app\models;

use Yii;
use app\models\base\PropuestaCentro as BasePropuestaCentro;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "propuesta_centro".
 */
class PropuestaCentro extends BasePropuestaCentro
{
    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'nombre_centro' => Yii::t('models', 'Nombre del centro'),
                'documento_firma' => Yii::t('models', 'Informe favorable de la Junta de Centro'),
            ]
        );
    }

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                // custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                // custom validation rules
            ]
        );
    }
}
