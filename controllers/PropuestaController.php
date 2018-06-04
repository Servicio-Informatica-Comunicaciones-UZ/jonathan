<?php

namespace app\controllers;

use app\jobs\PrintPdfJob;
use app\jobs\SendMailJob;
use app\models\Estado;
use app\models\FicheroPdf;
use app\models\Pregunta;
use app\models\Propuesta;
use app\models\PropuestaCentro;
use app\models\PropuestaDoctorado;
use app\models\PropuestaGrupoInves;
use app\models\PropuestaMacroarea;
use app\models\PropuestaTitulacion;
use Cocur\BackgroundProcess\BackgroundProcess;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

/**
 * This is the class for controller "PropuestaController".
 */
class PropuestaController extends \app\controllers\base\PropuestaController
{
    public function behaviors()
    {
        $id = Yii::$app->request->get('id');

        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['crear', 'listado'],
                        'allow' => true,
                        'roles' => ['@'],
                    ], [
                        'actions' => ['editar', 'presentar'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) use ($id) {
                            $usuario = Yii::$app->user;
                            $propuesta = $this->findModel($id);
                            return $usuario->id === $propuesta->user_id;
                        },
                        'roles' => ['@'],
                    ], [
                        'actions' => ['ver'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) use ($id) {
                            // Para que la app pueda generar los PDF.
                            $server_adresses = gethostbynamel($_SERVER['SERVER_NAME']);
                            array_push($server_adresses, '127.0.0.1', '::1');
                            if (in_array(Yii::$app->request->remoteIP, $server_adresses)) {
                                return true;
                            }
                            $propuesta = $this->findModel($id);
                            return Yii::$app->user->id === $propuesta->user_id;
                        },
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        return Yii::$app->getResponse()->redirect(['//saml/login']);
                    }
                    throw new ForbiddenHttpException(
                        Yii::t('app', 'No tiene permisos para acceder a esta página. 😨')
                    );
                },
            ],
        ];
    }

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

                            $ficheroPdf = new FicheroPdf();
                            $ficheroPdf->fichero = UploadedFile::getInstance($ficheroPdf, "[centro-{$num}]fichero");
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
                    foreach ($grupos as $num => $grupo) {
                        if ($grupo['nombre_grupo_inves']) {
                            $pg = new PropuestaGrupoInves([
                                'propuesta_id' => $model->id,
                                'nombre_grupo_inves' => $grupo['nombre_grupo_inves'],
                            ]);
                            if ($pg->validate()) {
                                $pg->save(false);
                            } else {
                                $model->addError('_exception', $pg->getErrorSummary(true));
                                throw new Exception();
                            }

                            $ficheroPdf = new FicheroPdf();
                            $ficheroPdf->fichero = UploadedFile::getInstance($ficheroPdf, "[grupo-{$num}]fichero");
                            if (isset($ficheroPdf->fichero) && $ficheroPdf->upload('firmas_grupos_inves', $pg->id)) {
                                $pg->documento_firma = $ficheroPdf->fichero->name;
                                $pg->save();
                            }
                        }
                    }
                }

                $transaction->commit();

                $model->log .= date(DATE_RFC3339) . ' — ' . Yii::t('jonathan', 'Creación de la propuesta') . "\n";
                $model->save();
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
        if (Estado::BORRADOR != $model->estado_id) {
            throw new ServerErrorHttpException(
                Yii::t('jonathan', 'Esta propuesta ya ha sido presentada, por lo que ya no se puede editar. 😨')
            );
        }

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
            // Guardamos los centros recibidos.
            $centros_anteriores = $model->propuestaCentros;
            $centros_recibidos = Yii::$app->request->post('PropuestaCentro') ?? [];
            foreach ($centros_recibidos as $num => $datos_centro) {
                $pc = isset($datos_centro['id']) ? PropuestaCentro::findOne(['id' => $datos_centro['id']])
                                                 : new PropuestaCentro();
                $pc->attributes = $datos_centro;
                $pc->propuesta_id = $model->id;
                $pc->save();

                $ficheroPdf = new FicheroPdf();
                $ficheroPdf->fichero = UploadedFile::getInstance($ficheroPdf, "[centro-{$num}]fichero");
                if (isset($ficheroPdf->fichero) && $ficheroPdf->upload('firmas_centros', $pc->id)) {
                    $pc->documento_firma = $ficheroPdf->fichero->name;
                    $pc->save();
                }
            }
            // Eliminamos los centros que se hayan quitado.
            $ids_recibidos = array_column($centros_recibidos, 'id');
            $centros_quitados = array_filter($centros_anteriores, function ($c) use ($ids_recibidos) {
                return !in_array($c->id, $ids_recibidos);
            });
            foreach ($centros_quitados as $c) {
                @unlink(Yii::getAlias('@webroot') . "/pdf/firmas_centros/{$c->id}.pdf");
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
                            'nombre_titulacion' => $titulacion['nombre_titulacion'],
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
                        $pd = new PropuestaDoctorado([
                            'propuesta_id' => $model->id,
                            'nombre_doctorado' => $doctorado['nombre_doctorado'],
                        ]);
                        $pd->save();
                    }
                }
            }

            /* Tabla propuesta_grupo_inves */
            // Guardamos los grupos de investigación recibidos.
            $grupos_anteriores = $model->propuestaGrupoInves;
            $grupos_recibidos = Yii::$app->request->post('PropuestaGrupoInves') ?? [];
            foreach ($grupos_recibidos as $num => $datos_grupo) {
                $pg = isset($datos_grupo['id']) ? PropuestaGrupoInves::findOne(['id' => $datos_grupo['id']])
                                                : new PropuestaGrupoInves();
                $pg->attributes = $datos_grupo;
                $pg->propuesta_id = $model->id;
                $pg->save();

                $ficheroPdf = new FicheroPdf();
                $ficheroPdf->fichero = UploadedFile::getInstance($ficheroPdf, "[grupo-{$num}]fichero");
                if (isset($ficheroPdf->fichero) && $ficheroPdf->upload('firmas_grupos_inves', $pg->id)) {
                    $pg->documento_firma = $ficheroPdf->fichero->name;
                    $pg->save();
                }
            }
            // Eliminamos los grupos de investigación que se hayan quitado.
            $ids_recibidos = array_column($grupos_recibidos, 'id');
            $grupos_quitados = array_filter($grupos_anteriores, function ($g) use ($ids_recibidos) {
                return !in_array($g->id, $ids_recibidos);
            });
            foreach ($grupos_quitados as $g) {
                @unlink(Yii::getAlias('@webroot') . "/pdf/firmas_grupos_inves/{$g->id}.pdf");
                $g->delete();
            }

            $transaction->commit();
            Yii::$app->session->addFlash(
                'success',
                Yii::t('jonathan', 'Cambios guardados con éxito.')
            );

            return $this->redirect(Url::previous());
        } else {
            return $this->render('editar', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Muestra un listado de las propuestas realizadas por un usuario.
     */
    public function actionListado()
    {
        $dpPropuestas = Propuesta::getDpPropuestasDelUsuario(Yii::$app->user->identity->id);

        return $this->render('listado', ['dpPropuestas' => $dpPropuestas]);
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
        $propuesta = $this->findModel($id);
        $preguntas = Pregunta::find()
            ->where(['anyo' => $propuesta->anyo, 'tipo_estudio_id' => $propuesta->tipo_estudio_id])
            ->orderBy('orden')
            ->all();

        return $this->render('ver', [
            'model' => $propuesta,
            'preguntas' => $preguntas,
        ]);
    }

    /**
     * Cambia el estado de una propuesta a Presentada.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionPresentar($id)
    {
        $model = $this->findModel($id);
        if (Estado::PRESENTADA == $model->estado_id) {
            throw new ServerErrorHttpException(Yii::t('jonathan', 'Esta propuesta ya estaba presentada. 😨'));
        }
        $model->estado_id = Estado::PRESENTADA;
        $model->log .= date(DATE_RFC3339) . ' — ' . Yii::t('jonathan', 'Presentación de la propuesta') . "\n";
        $model->save();
        Yii::info(
            sprintf(
                '%s (%s) ha presentado la propuesta %d (%s)',
                Yii::$app->user->identity->username,
                Yii::$app->user->identity->profile->name,
                $id,
                $model->denominacion
            ),
            'usuarios'
        );

        // Creamos una tarea para generar un PDF.
        Yii::$app->queue->push(new PrintPdfJob([
            'chromePath' => Yii::$app->params['chromePath'],
            'url' => Url::to(['propuesta/ver', 'id' => $id], true),
            'outputDirectory' => Yii::getAlias('@webroot') . '/pdf/propuestas',
            'filename' => "{$id}.pdf",
        ]));

        // Encolamos otra tarea a continuación de la anterior, para enviar correo.
        Yii::$app->queue->push(new SendMailJob([
            'attachmentPath' => Yii::getAlias('@webroot') . "/pdf/propuestas/{$id}.pdf",
            'recipients' => $model->user->email,
            'sender' => [Yii::$app->params['adminEmail'] => 'Robot Olba'],
            'subject' => Yii::t('jonathan', 'Propuesta presentada') . ': ' . $model->denominacion,
            'view' => 'propuesta-presentada',  // Fichero de vista, por omisión en @app/mail
            'viewParams' => ['denominacion' => $model->denominacion],
        ]));

        // Lanzamos el procesamiento de la cola en segundo plano
        $cmd = Yii::getAlias('@app') . '/yii queue/run';  // --verbose --isolate
        $bgprocess = new BackgroundProcess($cmd);
        $bgprocess->run();

        Yii::$app->session->addFlash(
            'success',
            Yii::t(
                'jonathan',
                "La propuesta ha sido presentada correctamente.\n" .
                    "En breve debería recibir un correo electrónico de confirmación.\n" .
                    'No obstante, si lo desea puede imprimir está página a modo de resguardo.'
            )
        );

        return $this->redirect(['ver', 'id' => $id]);
    }
}
