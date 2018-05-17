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
    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'nombre_grupo_inves' => Yii::t('models', 'Nombre del Grupo de Investigación'),
                'documento_firma' => Yii::t('models', 'Documento firmado por el Investigador Principal'),
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
                # custom validation rules
            ]
        );
    }
}
