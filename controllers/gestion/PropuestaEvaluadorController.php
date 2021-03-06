<?php

namespace app\controllers\gestion;

use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use app\models\Estado;
use app\models\Propuesta;
use app\models\PropuestaSearch;
use app\models\PropuestaEvaluador;
use app\models\PropuestaEvaluadorSearch;

/**
 * This is the class for controller "gestion/PropuestaEvaluadorController".
 */
class PropuestaEvaluadorController extends \app\controllers\base\PropuestaEvaluadorController
{
    public $enableCsrfValidation = true;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['gestorMasters'],
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
     * Devuelve una evaluación al estado Pendiente.
     */
    public function actionAbrir($id)
    {
        $asignacion = $this->findModel($id);
        $asignacion->estado_id = Estado::VALORACION_PENDIENTE;
        $asignacion->save();

        Yii::info(
            sprintf(
                '%s ha vuelto a abrir la valoración de la propuesta %s del evaluador %s.',
                Yii::$app->user->identity->profile->name,
                $asignacion->propuesta->denominacion,
                $asignacion->user->profile->name
            ),
            'gestion'
        );

        Yii::$app->session->addFlash(
            'success',
            sprintf(
                Yii::t('gestion', 'Se ha vuelto a abrir la evaluación de la propuesta «%s» por el evaluador «%s».'),
                $asignacion->propuesta->denominacion,
                $asignacion->user->profile->name
            )
        );

        return $this->redirect(['//gestion/propuesta-evaluador/valoraciones', 'anyo' => $asignacion->propuesta->anyo]);
    }

    /**
     * Muestra un listado de las asignaciones Propuesta ⟷ Evaluador.
     */
    public function actionListado($anyo, $estado_id = null)
    {
        Url::remember();
        if (!$estado_id) {
            $estado_id = [Estado::APROB_INTERNA, Estado::PRESENTADA_FASE_2];
        }
        $searchModel = new PropuestaSearch;
        $dpEvaluables = $searchModel->search(
            [
                'PropuestaSearch' => [
                    'anyo' => $anyo,
                    'estado_id' => $estado_id,
                ],
            ]
        );
        $dpEvaluables->sort->defaultOrder = ['estado_id' => SORT_ASC, 'denominacion' => SORT_ASC];

        return $this->render('listado', ['dpEvaluables' => $dpEvaluables, 'searchModel' => $searchModel]);
    }

    /** Muestra un listado de cada una de las evaluaciones individualmente, y su estado */
    public function actionValoraciones($anyo)
    {
        $searchModel = new PropuestaEvaluadorSearch(['anyo' => $anyo]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $estados_map = ArrayHelper::map(
            Estado::find()->where(['id' => Estado::DE_VALORACIONES])->asArray()->all(),
            'id',
            'nombre'
        );
        $mapa_estados = array_map(function ($nombre_estado) {
            return Yii::t('db', $nombre_estado);
        }, $estados_map);

        return $this->render(
            'valoraciones',
            ['dataProvider' => $dataProvider, 'mapa_estados' => $mapa_estados, 'searchModel' => $searchModel]
        );
    }

    /**
     * Muestra la página para modificar los evaluadores de la propuesta indicada.
     */
    public function actionEditarEvaluadores($id)
    {
        Url::remember();
        $propuesta = Propuesta::getPropuesta($id);
        $model = new PropuestaEvaluador();

        try {
            if ($model->load($_POST) && $model->save()) {
                Yii::info(
                    sprintf(
                        '%s ha asignado la propuesta «%s» al evaluador %s.',
                        Yii::$app->user->identity->profile->name,
                        $model->propuesta->denominacion,
                        $model->user->profile->name
                    ),
                    'gestion'
                );

                return $this->redirect(['editar-evaluadores', 'id' => $id]);
            } elseif (!\Yii::$app->request->isPost) {
                $model->load($_GET);
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();
            $model->addError('_exception', $msg);
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => PropuestaEvaluador::find()->where(['propuesta_id' => $id])->orderBy(['fase' => SORT_ASC])->all(),
        ]);

        return $this->render('editar-evaluadores', ['model' => $model, 'propuesta' => $propuesta, 'dataProvider' => $dataProvider]);
    }

    /**
     * Deletes an existing PropuestaEvaluador model.
     * If deletion is successful, the browser will be redirected to the 'editar-evaluadores' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionBorrar($id)
    {
        try {
            $model = $this->findModel($id);
            $model->delete();

            Yii::info(
                sprintf(
                    '%s ha desasignado la propuesta «%s» al evaluador %s.',
                    Yii::$app->user->identity->profile->name,
                    $model->propuesta->denominacion,
                    $model->user->profile->name
                ),
                'gestion'
            );
            Yii::$app->session->addFlash(
                'success',
                sprintf(Yii::t('gestion', 'Se ha quitado al evaluador %s de esta propuesta.'), $model->user->profile->name)
            );
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();
            \Yii::$app->getSession()->addFlash('error', $msg);

            return $this->redirect(Url::previous());
        }

        return $this->redirect(Url::previous());
    }
}
