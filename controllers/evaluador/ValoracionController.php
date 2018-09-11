<?php

namespace app\controllers\evaluador;

use Yii;

use app\models\Bloque;
use app\models\Propuesta;
use app\models\PropuestaEvaluador;
use app\models\Respuesta;
use app\models\Valoracion;

/**
* This is the class for controller "evaluador/ValoracionController".
*/
class ValoracionController extends \app\controllers\base\ValoracionController
{
    public $enableCsrfValidation = true;

    public function behaviors()
    {
        $id = Yii::$app->request->get('id');
        $respuesta_id = Yii::$app->request->get('respuesta_id');

        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['crear'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) use ($respuesta_id) {
                            $respuesta = Respuesta::getModel($respuesta_id);
                            $asignadas = PropuestaEvaluador::find()->select('propuesta_id')->delEvaluador(Yii::$app->user->id)->column();
                            return in_array($respuesta->propuesta_id, $asignadas);
                        },
                        'roles' => ['evaluador'],
                    ], [
                        'actions' => ['editar'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) use ($id) {
                            $usuario = Yii::$app->user;
                            $valoracion = $this->findModel($id);
                            return $usuario->id === $valoracion->user_id;
                        },
                        'roles' => ['evaluador'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    if (Yii::$app->user->isGuest) {
                        return Yii::$app->getResponse()->redirect(['//user/login']);
                    }
                    throw new ForbiddenHttpException(
                        Yii::t('app', 'No tiene permisos para acceder a esta página. 😨')
                    );
                },
            ],
        ];
    }


    public function actionCrear($bloque_id, $respuesta_id)
    {
        $bloque = Bloque::getModel($bloque_id);
        $respuesta = Respuesta::getModel($respuesta_id);

        $model = new Valoracion();

        try {
            if ($model->load(Yii::$app->request->post())) {
                $model->propuesta_id = $respuesta->propuesta_id;
                $model->bloque_id = $bloque->id;
                $model->respuesta_id = $respuesta_id;
                $model->user_id = Yii::$app->user->id;

                if ($model->save()) {
                    Yii::$app->session->addFlash('success', Yii::t(
                        'jonathan',
                        'Su evaluación se ha guardado con éxito.'
                    ));
                    Yii::info(
                        sprintf(
                            '%s (%s) ha evaluado el bloque «%d» de la propuesta %d (%s).',
                            Yii::$app->user->identity->username,
                            Yii::$app->user->identity->profile->name,
                            $model->bloque_id,
                            $model->propuesta_id,
                            $model->propuesta->denominacion
                        ),
                        'evaluador'
                    );

                    return $this->redirect(['//evaluador/propuesta/ver', 'propuesta_id' => $model->propuesta_id]);
                }
            } elseif (!\Yii::$app->request->isPost) {
                // $model->load(Yii::$app->request->get());
                $model->attributes = Yii::$app->request->get();  // Cargamos bloque_id y respuesta_id de la URL
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();
            $model->addError('_exception', $msg);
            Yii::$app->session->addFlash('error', $msg);
        }

        return $this->render('crear', ['model' => $model]);
    }

    /**
     * Edita una evaluación ya existente.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionEditar($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->update(true, ['comentarios', 'puntuacion'])) {
            Yii::$app->session->addFlash('success', Yii::t(
                'jonathan',
                'Su evaluación se ha actualizado con éxito.'
            ));
            Yii::info(
                sprintf(
                    '%s (%s) ha actualizado la valoración del bloque «%d» de la propuesta %d (%s).',
                    Yii::$app->user->identity->username,
                    Yii::$app->user->identity->profile->name,
                    $model->bloque_id,
                    $model->propuesta_id,
                    $model->propuesta->denominacion
                ),
                'evaluador'
            );

            return $this->redirect(['//evaluador/propuesta/ver', 'propuesta_id' => $model->propuesta_id]);
        } else {
            foreach ($model->getErrors() as $campo_con_errores) {
                foreach ($campo_con_errores as $error) {
                    Yii::$app->session->addFlash('error', $error);
                }
            }

            return $this->render('editar', ['model' => $model]);
        }
    }
}
