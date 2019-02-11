<?php

namespace app\models;

use app\models\base\Estado as BaseEstado;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "estado".
 */
class Estado extends BaseEstado
{
    // Valores definidos en m180410_100001_insert_estado_values y migraciones posteriores
    const BORRADOR = 1;
    const PRESENTADA = 2;
    const FUERA_DE_PLAZO = 8;
    const APROB_INTERNA = 3;
    const RECHAZ_INTERNO = 5;
    const APROB_EXTERNA = 4;
    const RECHAZ_EXTERNO = 9;
    const FUERA_DE_PLAZO_FASE_2 = 10;
    const PRESENTADA_FASE_2 = 11;
    const RECHAZ_EXTERNO_FASE_2 = 12;
    const APROB_EXTERNA_FASE_2 = 13;
    const DE_PROPUESTAS = [1, 2, 8, 3, 4, 5, 9, 10, 11, 12, 13];
    const EN_FASE_1 = [1, 2, 8, 3, 5, 9];
    const EN_FASE_2 = [4, 10, 11, 12, 13];

    const VALORACION_PENDIENTE = 6;
    const VALORACION_PRESENTADA = 7;
    const DE_VALORACIONES = [6, 7];

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
     * Finds the Estado model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @throws HttpException if the model cannot be found
     *
     * @param int $id
     *
     * @return Estado the loaded model
     */
    public static function getModel($id)
    {
        if (null !== ($model = static::findOne(['id' => $id]))) {
            return $model;
        }

        throw new yii\web\NotFoundHttpException(Yii::t('jonathan', 'No se ha encontrado ese estado.  ☹'));
    }
}
