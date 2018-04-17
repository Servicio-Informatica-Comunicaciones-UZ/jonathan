<?php

namespace app\controllers;

use app\models\Propuesta;
use app\models\PropuestaCentro;
use app\models\PropuestaMacroarea;

/**
 * This is the class for controller "PropuestaController".
 */
class PropuestaController extends \app\controllers\base\PropuestaController
{
    public function actionCrear()
    {
        $model = new Propuesta();

        try {
            if ($model->load($_POST) && $model->save()) {
                $macroareas = $_POST['Propuesta']['propuestaMacroareas'];
                foreach ($macroareas as $macroarea) {
                    $pm = new PropuestaMacroarea();
                    $pm->propuesta_id = $model->id;
                    $pm->macroarea_id = $macroarea;
                    $pm->save();
                }
                $centros = $_POST['Propuesta']['propuestaCentros'];
                foreach ($centros as $centro) {
                    $pc = new PropuestaCentro();
                    $pc->propuesta_id = $model->id;
                    $pc->nombre_centro = $centro;
                    $pc->save();
                }

                return $this->redirect(['view', 'id' => $model->id]);
            } elseif (!\Yii::$app->request->isPost) {
                $model->load($_GET);
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();
            $model->addError('_exception', $msg);
        }

        return $this->render('crear', ['model' => $model]);
    }
}
