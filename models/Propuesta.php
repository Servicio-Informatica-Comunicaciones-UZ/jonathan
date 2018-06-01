<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use \app\models\base\Propuesta as BasePropuesta;

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
                'estado_id' => Yii::t('models', 'ID del estado'),
            ]
        );
    }

    /**
     * Devuelve un DataProvider con las propuestas creadas por un usuario.
     */
    public static function getDpPropuestasDelUsuario($user_id)
    {
        $query = self::find()
            ->where(['user_id' => $user_id])
            ->orderBy(['anyo' => SORT_DESC, 'denominacion' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }

    /**
     * Devuelve un DataProvider con las propuestas de un año que estén en un estado determinado.
     */
    public static function getDpPropuestasEnEstado($anyo, $estado_id)
    {
        $query = self::find()
            ->where(['anyo' => $anyo, 'estado_id' => $estado_id])
            ->orderBy(['denominacion' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
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
        if (null !== ($model = self::findOne(['id' => $id]))) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('jonathan', 'No se ha encontrado esa propuesta.  ☹'));
    }
}
