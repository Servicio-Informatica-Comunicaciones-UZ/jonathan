<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "pregunta".
 *
 * @property integer $id
 * @property integer $anyo
 * @property string $titulo
 * @property string $descripcion
 * @property integer $max_longitud
 * @property integer $orden
 * @property integer $tipo_estudio_id
 *
 * @property \app\models\TipoEstudio $tipoEstudio
 * @property \app\models\Respuesta[] $respuestas
 * @property string $aliasModel
 */
abstract class Pregunta extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pregunta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['anyo', 'max_longitud', 'orden', 'tipo_estudio_id'], 'integer'],
            [['descripcion'], 'string'],
            [['titulo'], 'string', 'max' => 100],
            [['tipo_estudio_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\TipoEstudio::className(), 'targetAttribute' => ['tipo_estudio_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('models', 'ID'),
            'anyo' => Yii::t('models', 'Anyo'),
            'titulo' => Yii::t('models', 'Titulo'),
            'descripcion' => Yii::t('models', 'Descripcion'),
            'max_longitud' => Yii::t('models', 'Max Longitud'),
            'orden' => Yii::t('models', 'Orden'),
            'tipo_estudio_id' => Yii::t('models', 'Tipo Estudio ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoEstudio()
    {
        return $this->hasOne(\app\models\TipoEstudio::className(), ['id' => 'tipo_estudio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRespuestas()
    {
        return $this->hasMany(\app\models\Respuesta::className(), ['pregunta_id' => 'id']);
    }




}