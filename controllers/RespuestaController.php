<?php

namespace app\controllers;

use app\models\Propuesta;
use app\models\Pregunta;
use app\models\Respuesta;
use Yii;
use yii\base\Model;

/**
 * This is the class for controller "RespuestaController".
 */
class RespuestaController extends \app\controllers\base\RespuestaController
{
    public function actionCrear($propuesta_id)
    {
        $respuestas = Yii::$app->request->post('Respuesta');
        if (!$respuestas) {
            $respuestas = [];
        }
        $models = [];
        foreach ($respuestas as $respuesta) {
            $models[] = new Respuesta();
        }
        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
            foreach ($models as $model) {
                $model->save(false);
            }

            return $this->redirect(['propuesta/view', 'id' => $propuesta_id]);
        } elseif (!\Yii::$app->request->isPost) {
            $propuesta = Propuesta::findOne(['id' => $propuesta_id]);

            $preguntas = Pregunta::find()
                ->where(['anyo' => $propuesta->anyo, 'tipo_estudio_id' => $propuesta->tipo_estudio_id])
                ->orderBy('orden')
                ->all();

            foreach ($preguntas as $pregunta) {
                $respuesta = new Respuesta();
                $respuesta->propuesta_id = $propuesta_id;
                $respuesta->pregunta_id = $pregunta->id;
                $models[] = $respuesta;
            }
            if (Yii::$app->request->get('Respuesta')) {
                Model::loadMultiple($models, Yii::$app->request->get());
            }
        }

        return $this->render(
            'crear',
            [
                'propuesta' => $propuesta,
                'models' => $models,
            ]
        );
    }
}
