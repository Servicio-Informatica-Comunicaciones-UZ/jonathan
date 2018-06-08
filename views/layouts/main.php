<?php
/**
 * Vista de la plantilla principal de las páginas web.
 *
 * @author  Enrique Matías Sánchez <quique@unizar.es>
 * @license GPL-3.0+
 */

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\models\Enlace;
use app\widgets\Alert;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
$this->registerMetaTag([
    'name' => 'author',
    'content' => Yii::t(
        'app',
        'Área de Aplicaciones. Servicio de Informática y Comunicaciones de la Universidad de Zaragoza.'
    ),
]);

$enlaces = array_map(function ($e) {
    return ['label' => $e->nombre, 'url' => $e->uri];
}, Enlace::find()->all());
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Html::encode(Yii::$app->language) ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo Html::csrfMetaTags() ?>
    <title><?php echo Html::encode($this->title) ?></title>
    <link rel="icon" type="image/x-icon" href="<?php echo Url::home(); ?>favicon.ico">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' =>'<span class="icon-logoUZ"></span> <span class="screen-reader">Universidad de Zaragoza</span>',  // Yii::$app->name,
        'brandUrl' => 'http://www.unizar.es',  // Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo "\n" . Nav::widget([
        'items' => [
            /* ['label' => Yii::t('app', 'Inicio'), 'url' => ['//site/index']], */
            /* [
                'encode' => false,
                'label' => // "<span style='font-size: 36px; font-family: Universidad-de-Zaragoza; vertical-align: top;'>🗺</span> &nbsp;" .
                    '<i class="glyphicon glyphicon-globe navbar-icono"></i> &nbsp;' .
                    strtoupper(Html::encode(Yii::$app->language)),
                'items' => [
                    [
                        'label' => 'Castellano',
                        'url' => ['//language/set', 'language' => 'es'],
                    ], [
                        'label' => 'English',
                        'url' => ['//language/set', 'language' => 'en'],
                    ],
                ],
            ], */
            [
                'encode' => false,
                'label' => '<i class="glyphicon glyphicon-link navbar-icono"></i> &nbsp;' .
                            Yii::t('app', 'Enlaces'),
                'items' => $enlaces,
                'visible' => !empty($enlaces),
            ], [
                'encode' => false,
                'label' => '<i class="glyphicon glyphicon-education navbar-icono"></i> &nbsp;' .
                            Yii::t('app', 'Propuestas'),
                'url' => ['//propuesta/listado'],
                'visible' => !Yii::$app->user->isGuest,
            ], [
                'encode' => false,
                'label' => '<i class="glyphicon glyphicon-cog navbar-icono"></i> &nbsp;' .
                            Yii::t('app', 'Gestión'),
                'url' => ['//gestion/index'],
                'visible' => Yii::$app->user->can('gestionarMasters'),
            ], [
                'encode' => false,
                'label' => '<i class="glyphicon glyphicon-scale navbar-icono"></i> &nbsp;' .
                            Yii::t('jonathan', 'Valoración'),
                'url' => ['//evaluador/index'],
                'visible' => Yii::$app->user->can('valorar'),
            ], [
                'encode' => false,
                'label' => '<i class="glyphicon glyphicon-question-sign navbar-icono"></i> &nbsp;' .
                            Yii::t('app', 'Ayuda'),
                'url' => ['//site/ayuda'],
            ],
            Yii::$app->user->isGuest ? [
                'encode' => false,
                'label' => '<i class="glyphicon glyphicon-log-in navbar-icono"></i> &nbsp;' .
                            Yii::t('app', 'Iniciar sesión'),
                'url' => ['//saml/login']
            ] : [
                'encode' => false,
                'label' => '<i class="glyphicon glyphicon-log-out navbar-icono"></i> &nbsp;' .
                            sprintf('%s (%s)', Yii::t('app', 'Cerrar sesión'), Yii::$app->user->identity->username),
                'url' => ['//saml/logout'],
            ]
        ],
        'options' => ['class' => 'navbar-nav navbar-right'],
    ]);
    NavBar::end();
    ?>


    <div class="container" id="contenedor-principal">
        <?php
        echo Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]);
        echo Alert::widget();
        echo $content;
        echo '<hr class="hideinmainpage">';
        echo Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]);
        ?>
    </div>
</div>

<footer class="footer container">
    <div class="row">
        <div class="col-lg-8">
            &copy; <?php echo date('Y') . ' ' . Yii::t('app', 'Universidad de Zaragoza'); ?><br>
            &copy; <?php printf(
                '%d %s (%s)',
                date('Y'),
                Yii::t('app', 'Servicio de Informática y Comunicaciones de la Universidad de Zaragoza'),
                Html::a('SICUZ', 'http://sicuz.unizar.es')
            ); ?>
        </div>

        <div class="col-lg-2" style="text-align: right;">
            Universidad de Zaragoza<br>
            C/ Pedro Cerbuna, 12<br>
            E-50009 Zaragoza<br>
            España / Spain<br>
            Tel: +34 976761000<br>
            ciu@unizar.es<br>
            Q-5018001-G<br>
            <br>
            <a href="https://www.facebook.com/unizar.es">
                <span class="icon-facebook"></span><span class="screen-reader">Facebook</span>
            </a> &nbsp;
            <a href="https://twitter.com/unizar">
                <span class="icon-twitter"></span><span class="screen-reader">Twitter</span>
            </a>
        </div>

        <div class="col-lg-2">
            <a href="http://www.unizar.es">
                <span class="icon-unizar_es"></span><span class="screen-reader">Universidad de Zaragoza</span>
            </a>
        </div>
    </div>
    <hr style="border-color: #3b3b3b;">

    <p class="pull-right" style="font-size: 1.2rem">
        <a href="http://www.unizar.es/aviso-legal" target="_blank">
            <?php echo Yii::t('app', 'Aviso legal'); ?>
        </a> &nbsp; | &nbsp;
        <a href="http://www.unizar.es/condiciones-generales-de-uso" target="_blank">
            <?php echo Yii::t('app', 'Condiciones generales de uso'); ?>
        </a> &nbsp; | &nbsp;
        <a href="http://www.unizar.es/politica-de-privacidad" target="_blank">
            <?php echo Yii::t('app', 'Política de privacidad'); ?>
        </a>
    </p>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
