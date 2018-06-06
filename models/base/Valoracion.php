<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "valoracion".
 *
 * @property integer $id
 * @property integer $propuesta_id
 * @property integer $bloque_id
 * @property integer $respuesta_id
 * @property integer $user_id
 * @property string $comentarios
 * @property string $nota
 *
 * @property \app\models\Bloque $bloque
 * @property \app\models\Propuesta $propuesta
 * @property \app\models\Respuesta $respuesta
 * @property \app\models\User $user
 * @property string $aliasModel
 */
abstract class Valoracion extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'valoracion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['propuesta_id', 'bloque_id', 'respuesta_id', 'user_id'], 'integer'],
            [['comentarios'], 'string'],
            [['nota'], 'number'],
            [['bloque_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Bloque::className(), 'targetAttribute' => ['bloque_id' => 'id']],
            [['propuesta_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Propuesta::className(), 'targetAttribute' => ['propuesta_id' => 'id']],
            [['respuesta_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Respuesta::className(), 'targetAttribute' => ['respuesta_id' => 'id']],
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
            'bloque_id' => Yii::t('models', 'Bloque ID'),
            'respuesta_id' => Yii::t('models', 'Respuesta ID'),
            'user_id' => Yii::t('models', 'User ID'),
            'comentarios' => Yii::t('models', 'Comentarios'),
            'nota' => Yii::t('models', 'Nota'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBloque()
    {
        return $this->hasOne(\app\models\Bloque::className(), ['id' => 'bloque_id']);
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
    public function getRespuesta()
    {
        return $this->hasOne(\app\models\Respuesta::className(), ['id' => 'respuesta_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'user_id']);
    }




}
