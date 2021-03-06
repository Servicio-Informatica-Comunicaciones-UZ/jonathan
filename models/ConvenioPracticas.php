<?php

namespace app\models;

use Yii;
use \app\models\base\ConvenioPracticas as BaseConvenioPracticas;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "convenio_practicas".
 */
class ConvenioPracticas extends BaseConvenioPracticas
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

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'nombre_entidad' => Yii::t('models', 'Nombre de la institución o empresa'),
                'documento' => Yii::t('models', 'Convenio o compromiso firmado con la entidad'),
            ]
        );
    }
}
