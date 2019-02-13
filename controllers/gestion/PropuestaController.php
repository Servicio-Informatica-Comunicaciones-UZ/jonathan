<?php

namespace app\controllers\gestion;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use yii\web\ServerErrorHttpException;
use app\models\Estado;
use app\models\Pregunta;
use app\models\Propuesta;
use app\models\PropuestaSearch;

/**
 * This is the class for controller "gestion/PropuestaController".
 */
class PropuestaController extends \app\controllers\base\PropuestaController
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
     * Aprobación interna de una propuesta por parte de Organización Académica.
     * La propuesta cumple los criterios, por lo que puede pasar a los evaluadores externos.
     *
     * @param int $id El id de la propuesta
     *
     * @return mixed
     */
    public function actionAprobacionInterna($id)
    {
        $model = $this->findModel($id);
        if (Estado::PRESENTADA !== $model->estado_id) {
            throw new ServerErrorHttpException(Yii::t('jonathan', 'Esta propuesta no está en estado «Presentada». 😨'));
        }
        $model->estado_id = Estado::APROB_INTERNA;
        $model->log .= date(DATE_RFC3339) . ' — ' . Yii::t('jonathan', 'Aprobación interna de la propuesta') . "\n";
        $model->save();
        Yii::info(
            sprintf(
                '%s (%s) ha aprobado internamente la propuesta %d (%s)',
                Yii::$app->user->identity->username,
                Yii::$app->user->identity->profile->name,
                $id,
                $model->denominacion
            ),
            'gestion'
        );

        Yii::$app->session->addFlash(
            'success',
            Yii::t(
                'jonathan',
                "La propuesta ha sido aprobada internamente.\n" .
                    'Si lo desea, puede enviar un mensaje de correo electrónico al autor de la propuesta: '
            ) . Html::mailto(
                '"' . Html::encode($model->user->profile->name) . '" &lt;' . Html::encode($model->user->email) . '&gt;',
                $model->user->email . '?subject=' . Yii::t('jonathan', 'Propuesta aprobada internamente'),
                ['class' => 'alert-link']
            )
        );

        return $this->redirect(['ver', 'id' => $id]);
    }


    /**
     * Cambiar el estado de una propuesta a «Aprobada externamente».
     * La propuesta ha sido valorada positivamente por los evaluadores externos, por lo que puede pasar a la fase 2.
     *
     * @param int $id El id de la propuesta
     *
     * @return mixed
     */
    public function actionAprobarExternamente($id)
    {
        $model = $this->findModel($id);
        if (Estado::APROB_INTERNA !== $model->estado_id) {
            throw new ServerErrorHttpException(Yii::t('jonathan', 'Esta propuesta no está en estado «Aprobada internamente». 😨'));
        }
        $model->estado_id = Estado::APROB_EXTERNA;
        $model->log .= date(DATE_RFC3339) . ' — ' . Yii::t('jonathan', 'Aprobación externa de la propuesta') . "\n";
        $model->save();
        Yii::info(
            sprintf(
                '%s (%s) ha cambiado el estado de la propuesta %d (%s) a «%s»',
                Yii::$app->user->identity->username,
                Yii::$app->user->identity->profile->name,
                $id,
                $model->denominacion,
                $model->estado->nombre
            ),
            'gestion'
        );

        Yii::$app->session->addFlash(
            'success',
            Yii::t(
                'jonathan',
                "Ha cambiado el estado de la propuesta «{$model->denominacion}» a «{$model->estado->nombre}».\n" .
                    'Si lo desea, puede enviar un mensaje de correo electrónico al autor de la propuesta: '
            ) . Html::mailto(
                '"' . Html::encode($model->user->profile->name) . '" &lt;' . Html::encode($model->user->email) . '&gt;',
                $model->user->email . '?subject=' . Yii::t('jonathan', 'Propuesta aprobada externamente'),
                ['class' => 'alert-link']
            )
        );

        return $this->redirect(['gestion/valoracion/resumen', 'anyo' => $model->anyo]);
    }


    /**
     * La propuesta no cumple los criterios, por lo que se devuelve al estado «Borrador»
     * para que el proponente la corrija.
     *
     * @param int $id El id de la propuesta
     *
     * @return mixed
     */
    public function actionDevolver($id)
    {
        $model = $this->findModel($id);
        if (Estado::PRESENTADA !== $model->estado_id) {
            throw new ServerErrorHttpException(Yii::t('jonathan', 'Esta propuesta no está en estado «Presentada». 😨'));
        }
        $model->estado_id = Estado::BORRADOR;
        $model->log .= date(DATE_RFC3339) . ' — ' . Yii::t('jonathan', 'Devolución de la propuesta') . "\n";
        $model->save();
        Yii::info(
            sprintf(
                '%s (%s) ha devuelto la propuesta %d (%s) al proponente.',
                Yii::$app->user->identity->username,
                Yii::$app->user->identity->profile->name,
                $id,
                $model->denominacion
            ),
            'gestion'
        );

        Yii::$app->session->addFlash(
            'success',
            Yii::t(
                'jonathan',
                "La propuesta ha sido devuelta al estado Borrador para que el proponente subsane sus defectos.\n" .
                    'Por favor, <strong>informe al autor de la propuesta</strong> enviándole un mensaje de correo electrónico: '
            ) . Html::mailto(
                '"' . Html::encode($model->user->profile->name) . '" &lt;' . Html::encode($model->user->email) . '&gt;',
                $model->user->email . '?subject=' . Yii::t('jonathan', 'Propuesta devuelta para subsanación de defectos'),
                ['class' => 'alert-link']
            )
        );

        return $this->redirect(['ver', 'id' => $id]);
    }

    /**
     * Rechazo interno de una propuesta por parte de Organización Académica.
     * La propuesta carece de interés, por lo que desestima y se archiva.
     *
     * @param int $id El id de la propuesta
     *
     * @return mixed
     */
    public function actionRechazar($id)
    {
        $model = $this->findModel($id);
        if (Estado::PRESENTADA !== $model->estado_id) {
            throw new ServerErrorHttpException(Yii::t('jonathan', 'Esta propuesta no está en estado «Presentada». 😨'));
        }
        $model->estado_id = Estado::RECHAZ_INTERNO;
        $model->log .= date(DATE_RFC3339) . ' — ' . Yii::t('jonathan', 'Rechazo interno de la propuesta') . "\n";
        $model->save();
        Yii::info(
            sprintf(
                '%s (%s) ha rechazado internamente la propuesta %d (%s)',
                Yii::$app->user->identity->username,
                Yii::$app->user->identity->profile->name,
                $id,
                $model->denominacion
            ),
            'gestion'
        );

        Yii::$app->session->addFlash(
            'success',
            Yii::t(
                'jonathan',
                "La propuesta ha sido rechazada internamente.\n" .
                    'Por favor, <strong>informe al autor de la propuesta</strong> enviándole un mensaje de correo electrónico: '
            ) . Html::mailto(
                '"' . Html::encode($model->user->profile->name) . '" &lt;' . Html::encode($model->user->email) . '&gt;',
                $model->user->email . '?subject=' . Yii::t('jonathan', 'Propuesta rechazada internamente'),
                ['class' => 'alert-link']
            )
        );

        return $this->redirect(['ver', 'id' => $id]);
    }

    /**
     * Cambiar el estado de una propuesta a «Rechazada externamente».
     * La propuesta ha sido valorada negativamente por los evaluadores externos, por lo que desestima y se archiva.
     *
     * @param int $id El id de la propuesta
     *
     * @return mixed
     */
    public function actionRechazarExternamente($id)
    {
        $model = $this->findModel($id);
        if (Estado::APROB_INTERNA !== $model->estado_id) {
            throw new ServerErrorHttpException(Yii::t('jonathan', 'Esta propuesta no está en estado «Aprobada internamente». 😨'));
        }
        $model->estado_id = Estado::RECHAZ_EXTERNO;
        $model->log .= date(DATE_RFC3339) . ' — ' . Yii::t('jonathan', 'Rechazo externo de la propuesta') . "\n";
        $model->save();
        Yii::info(
            sprintf(
                '%s (%s) ha cambiado el estado de la propuesta %d (%s) a «%s».',
                Yii::$app->user->identity->username,
                Yii::$app->user->identity->profile->name,
                $id,
                $model->denominacion,
                $model->estado->nombre
            ),
            'gestion'
        );

        Yii::$app->session->addFlash(
            'success',
            Yii::t(
                'jonathan',
                "Ha cambiado el estado de la propuesta «{$model->denominacion}» a «{$model->estado->nombre}».\n" .
                    'Por favor, <strong>informe al autor de la propuesta</strong> enviándole un mensaje de correo electrónico: '
            ) . Html::mailto(
                '"' . Html::encode($model->user->profile->name) . '" &lt;' . Html::encode($model->user->email) . '&gt;',
                $model->user->email . '?subject=' . Yii::t('jonathan', 'Propuesta rechazada externamente'),
                ['class' => 'alert-link']
            )
        );

        return $this->redirect(['gestion/valoracion/resumen', 'anyo' => $model->anyo]);
    }

    /**
     * Muestra un listado de las propuestas de un año.
     */
    public function actionListadoPropuestas($anyo)
    {
        $searchModel = new PropuestaSearch();
        $params = Yii::$app->request->queryParams;
        $params['PropuestaSearch']['anyo'] = $anyo;
        $dataProvider = $searchModel->search($params);

        $estados_map = ArrayHelper::map(
            Estado::find()->where(['id' => Estado::DE_PROPUESTAS])->asArray()->all(),
            'id',
            'nombre'
        );
        $mapa_estados = array_map(function ($nombre_estado) {
            return Yii::t('db', $nombre_estado);
        }, $estados_map);

        return $this->render(
            'listado-propuestas',
            ['dataProvider' => $dataProvider, 'mapa_estados' => $mapa_estados, 'searchModel' => $searchModel]
        );
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
            ->andWhere(['fase' => $propuesta->fase])
            ->orderBy('orden')
            ->all();

        return $this->render(
            'ver',
            [
                'model' => $propuesta,
                'preguntas' => $preguntas,
            ]
        );
    }
}
