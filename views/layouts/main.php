<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
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
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
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
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/saml/login']]
            ) : (
                ['label' => 'Logout', 'url' => ['/saml/logout']]
                /*
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
                */
            )
        ],
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
