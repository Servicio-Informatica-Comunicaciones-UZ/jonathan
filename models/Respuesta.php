<?php

namespace app\models;

use Yii;
use \app\models\base\Respuesta as BaseRespuesta;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "respuesta".
 */
class Respuesta extends BaseRespuesta
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

    /**
     * Finds the Respuesta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @throws HttpException if the model cannot be found
     *
     * @param int $id
     *
     * @return Respuesta the loaded model
     */
    public static function getModel($id)
    {
        if (null !== ($model = self::findOne(['id' => $id]))) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('jonathan', 'No se ha encontrado esa respuesta.  ☹'));
    }
}
