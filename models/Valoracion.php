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
                [['puntuacion'], 'number', 'min' => 0.0, 'max' => 5.0],
            ]
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'id' => Yii::t('models', 'ID'),
                'propuesta_id' => Yii::t('models', 'ID de la propuesta'),
                'bloque_id' => Yii::t('models', 'ID del bloque'),
                'respuesta_id' => Yii::t('models', 'ID de la respuesta'),
                'user_id' => Yii::t('models', 'ID del usuario'),
                'comentarios' => Yii::t('models', 'Comentarios'),
                'puntuacion' => Yii::t('models', 'Puntuación'),
            ]
        );
    }
}
