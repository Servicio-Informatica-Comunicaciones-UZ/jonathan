<?php

namespace app\controllers;

use app\models\Propuesta;
use app\models\PropuestaCentro;
use app\models\PropuestaMacroarea;
use Yii;

/**
 * This is the class for controller "PropuestaController".
 */
class PropuestaController extends \app\controllers\base\PropuestaController
{
    public function actionCrear()
    {
        $model = new Propuesta();

        try {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $macroareas = Yii::$app->request->post('Propuesta')['propuestaMacroareas'];
                if ($macroareas) {
                    foreach ($macroareas as $macroarea) {
                        $pm = new PropuestaMacroarea();
                        $pm->propuesta_id = $model->id;
                        $pm->macroarea_id = $macroarea;
                        $pm->save();
                    }
                }
                $centros = Yii::$app->request->post('Propuesta')['propuestaCentros'];
                foreach ($centros as $centro) {
                    if ($centro) {
                        $pc = new PropuestaCentro();
                        $pc->propuesta_id = $model->id;
                        $pc->nombre_centro = $centro;
                        $pc->save();
                    }
                }

                return $this->redirect(['view', 'id' => $model->id]);
            } elseif (!\Yii::$app->request->isPost) {
                $model->load(Yii::$app->request->get());
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();
            $model->addError('_exception', $msg);
        }

        return $this->render('crear', ['model' => $model]);
    }
}
