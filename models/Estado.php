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
    const APROB_INTERNA = 3;
    const APROB_EXTERNA = 4;
    const RECHAZ_INTERNO = 5;
    const EVALUABLES = [3, 4, 5];
    const FUERA_DE_PLAZO = 8;

    const VALORACION_PENDIENTE = 6;
    const VALORACION_PRESENTADA = 7;

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
}
