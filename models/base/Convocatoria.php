<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "convocatoria".
 *
 * @property integer $id
 * @property string $fecha_max_presentacion_fase_1
 * @property string $fecha_max_presentacion_fase_2
 * @property string $aliasModel
 */
abstract class Convocatoria extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'convocatoria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['fecha_max_presentacion_fase_1', 'fecha_max_presentacion_fase_2'], 'safe'],
            [['id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('models', 'ID'),
            'fecha_max_presentacion_fase_1' => Yii::t('models', 'Fecha Max Presentacion Fase 1'),
            'fecha_max_presentacion_fase_2' => Yii::t('models', 'Fecha Max Presentacion Fase 2'),
        ];
    }




}
