<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use \Da\User\Model\Profile;
use app\models\base\PropuestaEvaluador as BasePropuestaEvaluador;

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
                [['user_id'], 'required'],
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
            // Atributos de tablas relacionadas
            'nombreEvaluador' => Yii::t('models', 'Nombre del evaluador'),
        ];
    }

    /** Devuelve el nombre del evaluador */
    public function getNombreEvaluador()
    {
        return $this->user->profile->name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        // return $this->hasOne(\Da\User\Model\Profile::className(), ['user_id' => 'id'])->viaTable('user', ['id' => 'user_id']);
        return $this->hasOne(\Da\User\Model\Profile::className(), ['user_id' => 'user_id']);
    }
}
