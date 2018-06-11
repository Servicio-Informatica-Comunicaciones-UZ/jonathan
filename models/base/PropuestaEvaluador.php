<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "propuesta_evaluador".
 *
 * @property integer $id
 * @property integer $propuesta_id
 * @property integer $user_id
 *
 * @property \app\models\Propuesta $propuesta
 * @property \app\models\User $user
 * @property string $aliasModel
 */
abstract class PropuestaEvaluador extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'propuesta_evaluador';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['propuesta_id', 'user_id'], 'integer'],
            [['propuesta_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Propuesta::className(), 'targetAttribute' => ['propuesta_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\User::className(), 'targetAttribute' => ['user_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('models', 'ID'),
            'propuesta_id' => Yii::t('models', 'Propuesta ID'),
            'user_id' => Yii::t('models', 'User ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropuesta()
    {
        return $this->hasOne(\app\models\Propuesta::className(), ['id' => 'propuesta_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'user_id']);
    }




}
