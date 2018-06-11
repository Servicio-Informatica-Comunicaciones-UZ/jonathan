<?php

namespace app\models;

use Yii;
use app\models\base\PropuestaEvaluador as BasePropuestaEvaluador;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "propuesta_evaluador".
 */
class PropuestaEvaluador extends BasePropuestaEvaluador
{
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

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('models', 'ID'),
            'propuesta_id' => Yii::t('models', 'ID de la propuesta'),
            'user_id' => Yii::t('models', 'ID del evaluador'),
        ];
    }
}
