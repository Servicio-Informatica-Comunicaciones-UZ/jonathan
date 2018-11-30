<?php

namespace app\models;

use Yii;
use \app\models\base\Bloque as BaseBloque;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "bloque".
 */
class Bloque extends BaseBloque
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
     * Finds the Bloque model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @throws HttpException if the model cannot be found
     *
     * @param int $id
     *
     * @return Bloque the loaded model
     */
    public static function getModel($id)
    {
        if (null !== ($model = self::findOne(['id' => $id]))) {
            return $model;
        }

        throw new yii\web\NotFoundHttpException(Yii::t('jonathan', 'No se ha encontrado ese bloque.  ☹'));
    }
}
