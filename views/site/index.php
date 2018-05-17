<?php

/* @var $this yii\web\View */

$this->title = Yii::t('db', Yii::$app->name);

$this->registerMetaTag([
    'name' => 'description',
    'content' => Yii::t(
        'app',
        'Propuestas de nuevas titulaciones'
    ),
]);

$this->registerCssFile('@web/css/mainpage.css', ['depends' => 'app\assets\AppAsset']);
?>
<div class="site-index">

    <div class="jumbotron">
        <span class="icon-graduation-cap2"></span>
        <h1><?php echo Yii::t(
            'jonathan',
            'Propuestas de <strong>másteres</strong><br>universitarios'
        ); ?></h1>
        <span class="icon-stars" style="font-size: 2.4rem;"></span>
    </div>

    <div class="body-content">

    </div>
</div>
