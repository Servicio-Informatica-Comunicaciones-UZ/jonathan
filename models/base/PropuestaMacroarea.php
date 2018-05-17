<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "propuesta_macroarea".
 *
 * @property integer $id
 * @property integer $propuesta_id
 * @property integer $macroarea_id
 *
 * @property \app\models\Macroarea $macroarea
 * @property \app\models\Propuesta $propuesta
 * @property string $aliasModel
 */
abstract class PropuestaMacroarea extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'propuesta_macroarea';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['propuesta_id', 'macroarea_id'], 'integer'],
            [['macroarea_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Macroarea::className(), 'targetAttribute' => ['macroarea_id' => 'id']],
            [['propuesta_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Propuesta::className(), 'targetAttribute' => ['propuesta_id' => 'id']]
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
            'macroarea_id' => Yii::t('models', 'Macroarea ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMacroarea()
    {
        return $this->hasOne(\app\models\Macroarea::className(), ['id' => 'macroarea_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropuesta()
    {
        return $this->hasOne(\app\models\Propuesta::className(), ['id' => 'propuesta_id']);
    }




}
