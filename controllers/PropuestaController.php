<?php

namespace app\controllers;

use app\models\FicheroPdf;
use app\models\Propuesta;
use app\models\PropuestaCentro;
use app\models\PropuestaDoctorado;
use app\models\PropuestaGrupoInves;
use app\models\PropuestaMacroarea;
use app\models\PropuestaTitulacion;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * This is the class for controller "PropuestaController".
 */
class PropuestaController extends \app\controllers\base\PropuestaController
{
    /**
     * Crea una nueva propuesta.
     *
     * @return mixed
     */
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
                    foreach ($centros as $num => $centro) {
                        if ($centro['nombre_centro']) {
                            $pc = new PropuestaCentro([
                                'propuesta_id' => $model->id,
                                'nombre_centro' => $centro['nombre_centro'],
                            ]);
                            if ($pc->validate()) {
                                $pc->save(false);
                            } else {
                                $model->addError('_exception', $pc->getErrorSummary(true));
                                throw new Exception();
                            }

                            $ficheroPdf= new FicheroPdf();
                            $ficheroPdf->fichero = UploadedFile::getInstance($ficheroPdf, "[{$num}]fichero");
                            if (isset($ficheroPdf->fichero) && $ficheroPdf->upload('firmas_centros', $pc->id)) {
                                $pc->documento_firma = $ficheroPdf->fichero->name;
                                $pc->save();
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

    /**
     * Edita una propuesta ya existente.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionEditar($id)
    {
        $model = $this->findModel($id);
        $transaction = Yii::$app->db->beginTransaction();

        if ($model->load($_POST) && $model->save()) {
            /* Tabla propuesta_macroarea */
            $pms = $model->propuestaMacroareas;
            $macroareas = Yii::$app->request->post('Propuesta')['propuestaMacroareas'] ?: [];
            // Añadimos las nuevas macroáreas que pueda haber
            foreach ($macroareas as $macroarea) {
                if (!array_filter($pms, function ($pm) use ($macroarea) {
                    return $pm->macroarea_id == $macroarea;
                })) {
                    $pm = new PropuestaMacroarea(['propuesta_id' => $model->id, 'macroarea_id' => $macroarea]);
                    $pm->save();
                }
            }
            // Eliminamos las macroáreas que se hayan quitado
            $pms_quitadas = array_filter($pms, function ($pm) use ($macroareas) {
                return !in_array($pm->macroarea_id, $macroareas);
            });
            foreach ($pms_quitadas as $pm) {
                $pm->delete();
            }

            /* Tabla propuesta_centro */
            // Guardamos los centros actuales.
            $centros_anteriores = $model->propuestaCentros;
            $centros_enviados = Yii::$app->request->post('PropuestaCentro') ?? [];
            foreach ($centros_enviados as $num => $datos_centro) {
                $pc = isset($datos_centro['id']) ? PropuestaCentro::findOne(['id' => $datos_centro['id']])
                                                 : new PropuestaCentro;
                $pc->attributes = $datos_centro;
                $pc->propuesta_id = $model->id;
                $pc->save();

                $ficheroPdf = new FicheroPdf();
                $ficheroPdf->fichero = UploadedFile::getInstance($ficheroPdf, "[{$num}]fichero");
                if (isset($ficheroPdf->fichero) && $ficheroPdf->upload('firmas_centros', $pc->id)) {
                    $pc->documento_firma = $ficheroPdf->fichero->name;
                    $pc->save();
                }
            }
            // Eliminamos los centros que se hayan quitado.
            $ids_models = array_column($centros_enviados, 'id');
            $centros_quitados = array_filter($centros_anteriores, function ($c) use ($ids_models) {
                return !in_array($c->id, $ids_models);
            });
            foreach ($centros_quitados as $c) {
                unlink(Yii::getAlias('@webroot') . "/pdf/firmas_centros/{$c->id}.pdf");
                $c->delete();
            }

            foreach ($model->propuestaTitulacions as $t) {
                $t->delete();
            }
            $titulaciones = Yii::$app->request->post('PropuestaTitulacion');
            if ($titulaciones) {
                foreach ($titulaciones as $titulacion) {
                    if ($titulacion['nombre_titulacion']) {
                        $pt = new PropuestaTitulacion([
                            'propuesta_id' => $model->id,
                            'nombre_titulacion' => $titulacion['nombre_titulacion']
                        ]);
                        $pt->save();
                    }
                }
            }

            foreach ($model->propuestaDoctorados as $d) {
                $d->delete();
            }
            $doctorados = Yii::$app->request->post('PropuestaDoctorado');
            if ($doctorados) {
                foreach ($doctorados as $doctorado) {
                    if ($doctorado['nombre_doctorado']) {
                        $pd = new PropuestaDoctorado(['propuesta_id' => $model->id, 'nombre_doctorado' => $doctorado['nombre_doctorado']]);
                        $pd->save();
                    }
                }
            }

            foreach ($model->propuestaGrupoInves as $g) {
                $g->delete();
            }
            $grupos = Yii::$app->request->post('PropuestaGrupoInves');
            if ($grupos) {
                foreach ($grupos as $grupo) {
                    if ($grupo['nombre_grupo_inves']) {
                        $pg = new PropuestaGrupoInves(['propuesta_id' => $model->id, 'nombre_grupo_inves' => $grupo['nombre_grupo_inves']]);
                        $pg->save();
                    }
                }
            }

            $transaction->commit();

            return $this->redirect(Url::previous());
        } else {
            return $this->render('editar', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Muestra una única propuesta.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionVer($id)
    {
        Url::remember();

        return $this->render('ver', [
            'model' => $this->findModel($id),
        ]);
    }
}
