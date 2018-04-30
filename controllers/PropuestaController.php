<?php

namespace app\controllers;

use app\models\Propuesta;
use app\models\PropuestaCentro;
use app\models\PropuestaDoctorado;
use app\models\PropuestaGrupoInves;
use app\models\PropuestaMacroarea;
use app\models\PropuestaTitulacion;
use Yii;
use yii\base\Exception;

/**
 * This is the class for controller "PropuestaController".
 */
class PropuestaController extends \app\controllers\base\PropuestaController
{
    public function actionCrear()
    {
        $model = new Propuesta();

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $macroareas = Yii::$app->request->post('Propuesta')['propuestaMacroareas'];
                if ($macroareas) {
                    foreach ($macroareas as $macroarea) {
                        $pm = new PropuestaMacroarea();
                        $pm->propuesta_id = $model->id;
                        $pm->macroarea_id = $macroarea;
                        if (!$pm->save()) {
                            $model->addError('_exception', $pm->getErrorSummary(true));
                            throw new Exception();
                        }
                    }
                }

                $centros = Yii::$app->request->post('PropuestaCentro');
                if ($centros) {
                    foreach ($centros as $centro) {
                        if ($centro['nombre_centro']) {
                            $pc = new PropuestaCentro();
                            $pc->propuesta_id = $model->id;
                            $pc->nombre_centro = $centro['nombre_centro'];
                            if ($pc->validate()) {
                                $pc->save(false);
                            } else {
                                $model->addError('_exception', $pc->getErrorSummary(true));
                                throw new Exception();
                            }
                        }
                    }
                }

                $titulaciones = Yii::$app->request->post('PropuestaTitulacion');
                if ($titulaciones) {
                    foreach ($titulaciones as $titulacion) {
                        if ($titulacion['nombre_titulacion']) {
                            $pt = new PropuestaTitulacion();
                            $pt->propuesta_id = $model->id;
                            $pt->nombre_titulacion = $titulacion['nombre_titulacion'];
                            if ($pt->validate()) {
                                $pt->save(false);
                            } else {
                                $model->addError('_exception', $pt->getErrorSummary(true));
                                throw new Exception();
                            }
                        }
                    }
                }

                $doctorados = Yii::$app->request->post('PropuestaDoctorado');
                if ($doctorados) {
                    foreach ($doctorados as $doctorado) {
                        if ($doctorado['nombre_doctorado']) {
                            $pd = new PropuestaDoctorado();
                            $pd->propuesta_id = $model->id;
                            $pd->nombre_doctorado = $doctorado['nombre_doctorado'];
                            if ($pd->validate()) {
                                $pd->save(false);
                            } else {
                                $model->addError('_exception', $pd->getErrorSummary(true));
                                throw new Exception();
                            }
                        }
                    }
                }

                $grupos = Yii::$app->request->post('PropuestaGrupoInves');
                if ($grupos) {
                    foreach ($grupos as $grupo) {
                        if ($grupo['nombre_grupo_inves']) {
                            $pg = new PropuestaGrupoInves();
                            $pg->propuesta_id = $model->id;
                            $pg->nombre_grupo_inves = $grupo['nombre_grupo_inves'];
                            if (!$pg->save()) {
                                $model->addError('_exception', $pg->getErrorSummary(true));
                                throw new Exception();
                            }
                        }
                    }
                }

                $transaction->commit();

                return $this->redirect(['respuesta/crear', 'propuesta_id' => $model->id]);
            } elseif (!\Yii::$app->request->isPost) {
                $model->load(Yii::$app->request->get());
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();
            $model->addError('_exception', $msg);
            $transaction->rollBack();
        }

        return $this->render('crear', ['model' => $model]);
    }
}
