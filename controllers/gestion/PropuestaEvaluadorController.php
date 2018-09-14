<?php

namespace app\controllers\gestion;

use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use app\models\Estado;
use app\models\Propuesta;
use app\models\PropuestaEvaluador;

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
     * Muestra un listado de las asignaciones Propuesta ⟷ Evaluador.
     */
    public function actionListado($anyo)
    {
        Url::remember();
        $dpEvaluables = Propuesta::getDpEvaluables($anyo);

        return $this->render('listado', ['dpEvaluables' => $dpEvaluables]);
    }

    /** Muestra un listado de cada una de las evaluaciones individualmente, y su estado */
    public function actionValoraciones($anyo)
    {
        $asignacionesQuery = PropuestaEvaluador::find()
            ->innerJoin('propuesta')
            ->where([
                'propuesta.anyo' => $anyo,
                'propuesta.estado_id' => Estado::EVALUABLES,
            ]);

        $asignacionesDataProvider = new \yii\data\ActiveDataProvider([
            'query' => $asignacionesQuery,
            'pagination' => false,
            'sort' => [
                'attributes' => ['propuesta.denominacion', 'user_id', 'estado_id'],
            ],
        ]);

        return $this->render('valoraciones', ['asignacionesDataProvider' => $asignacionesDataProvider]);
    }

    /**
     * Muestra la página para modificar los evaluadores de la propuesta indicada.
     */
    public function actionEditarEvaluadores($id)
    {
        Url::remember();
        $propuesta = Propuesta::findOne(['id' => $id]);
        $model = new PropuestaEvaluador();

        try {
            if ($model->load($_POST) && $model->save()) {
                return $this->redirect(['editar-evaluadores', 'id' => $id]);
            } elseif (!\Yii::$app->request->isPost) {
                $model->load($_GET);
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();
            $model->addError('_exception', $msg);
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => PropuestaEvaluador::find()->where(['propuesta_id' => $id])->all(),
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
