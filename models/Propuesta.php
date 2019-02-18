<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use app\models\base\Propuesta as BasePropuesta;
use app\models\Estado;

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

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'anyo' => Yii::t('models', 'Año'),
                'user_id' => Yii::t('models', 'ID del usuario'),
                'denominacion' => Yii::t('models', 'Denominación de la titulación propuesta'),
                'orientacion_id' => Yii::t('models', 'Orientación del Máster'),
                'creditos' => Yii::t('models', 'Número de créditos'),
                'duracion' => Yii::t('models', 'Duración de los estudios (en semestres)'),
                'modalidad_id' => Yii::t('models', 'Modalidad de impartición'),
                'plazas' => Yii::t('models', 'Número de plazas ofertadas de nuevo ingreso'),
                'creditos_practicas' => Yii::t('models', 'Número de créditos para la realización de prácticas externas (en el caso de que las hubiere)'),
                'tipo_estudio_id' => Yii::t('models', 'ID del tipo de estudio'),
                'memoria_verificacion' => Yii::t('models', 'Memoria de verificación'),
                'memoria_economica' => Yii::t('models', 'Memoria económica'),
                'estado_id' => Yii::t('models', 'ID del estado'),
                // Atributos de tablas relacionadas
                'nombreProponente' => Yii::t('models', 'Nombre del responsable'),
            ]
        );
    }

    /**
     * Finds the Propuesta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @throws HttpException if the model cannot be found
     *
     * @param int $id
     *
     * @return Propuesta the loaded model
     */
    public static function getPropuesta($id)
    {
        if (null !== ($model = static::findOne(['id' => $id]))) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('jonathan', 'No se ha encontrado esa propuesta.  ☹'));
    }

    /**
     * Devuelve los usuarios evaluadores de una propuesta.
     */
    public function getEvaluadores()
    {
        $asignaciones = $this->propuestaEvaluadors;
        $fase = $this->fase;
        $asignaciones = array_filter($asignaciones, function ($asignacion) use ($fase) {
            return $asignacion->fase === $fase;
        });
        $evaluadores = ArrayHelper::getColumn($asignaciones, 'user');
        usort($evaluadores, ['\app\models\User', 'cmpProfileName']);

        return $evaluadores;
    }

    /**
     * Devuelve en qué fase se encuentra una propuesta.
     */
    public function getFase()
    {
        if (in_array($this->estado_id, Estado::EN_FASE_1)) {
            return 1;
        } elseif (in_array($this->estado_id, Estado::EN_FASE_2)) {
            return 2;
        }
        return null;
    }

    /**
     * Devuelve el nombre del proponente.
     */
    public function getNombreProponente()
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
