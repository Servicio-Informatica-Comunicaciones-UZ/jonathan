<?php

namespace app\models;

use Yii;
use \app\models\base\Propuesta as BasePropuesta;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "propuesta".
 */
class Propuesta extends BasePropuesta
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
                'denominacion' => Yii::t('models', 'Denominación de la titulación propuesta'),
                'orientacion_id' => Yii::t('models', 'Orientación del Máster'),
                'creditos' => Yii::t('models', 'Número de créditos'),
                'duracion' => Yii::t('models', 'Duración de los estudios (en cuatrimestres)'),
                'modalidad_id' => Yii::t('models', 'Modalidad de impartición'),
                'plazas' => Yii::t('models', 'Número de plazas ofertadas de nuevo ingreso'),
                'creditos_practicas' => Yii::t('models', 'Número de créditos para la realización de prácticas externas (en el caso de que las hubiere)'),
                'nip' => Yii::t('models', 'Responsable de la propuesta'),
            ]
        );
    }

}
