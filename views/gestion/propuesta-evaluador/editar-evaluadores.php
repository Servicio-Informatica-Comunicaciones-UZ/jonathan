<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = sprintf(
    Yii::t('jonathan', 'Evaluadores de «%s»'),
    Html::encode($propuesta->denominacion)
);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gestión'), 'url' => ['//gestion/index']];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('jonathan', 'Asignaciones Propuesta⟷Evaluador'),
    'url' => ['listado', 'anyo' => $propuesta->anyo],
];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?php echo $this->title; ?></h1>
<hr><br>

<ul class='listado'>
    <?php

    foreach ($propuesta->evaluadores as $evaluador) {
        printf("<li>%s</li>\n", Html::encode($evaluador->profile->name));
    }
    ?>
</ul>

<hr>

<h2><?php echo Yii::t('jonathan', 'Nuevo evaluador'); ?></h2>

<div class="propuesta-evaluador-form">

<?php
$form = ActiveForm::begin([
    'id' => 'PropuestaEvaluador',
    'layout' => 'default',  // 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    'fieldConfig' => [
        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
        'horizontalCssClasses' => [
            'label' => 'col-sm-2',
            //'offset' => 'col-sm-offset-4',
            'wrapper' => 'col-sm-8',
            'error' => '',
            'hint' => '',
        ],
    ],
]);

// attribute propuesta_id
echo $form->field($model, 'propuesta_id')->hiddenInput(['value' => $propuesta->id])->label(false);

// attribute user_id
echo $form->field($model, 'user_id')->dropDownList(
    \yii\helpers\ArrayHelper::map(app\models\User::find()->all(), 'id', 'profile.name'),
    [
        'prompt' => Yii::t('jonathan', 'Seleccione el evaluador'),
        'disabled' => (isset($relAttributes) && isset($relAttributes['user_id'])),
    ]
)->label(false);

echo $form->errorSummary($model) . "\n";

echo "<div class='form-group'>\n";
echo Html::submitButton(
    '<span class="glyphicon glyphicon-check"></span> ' . Yii::t('jonathan', 'Añadir'),
    [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success',
    ]
) . "\n";
echo "</div>\n";

ActiveForm::end();
?>

</div>
