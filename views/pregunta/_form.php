<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var app\models\Pregunta $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="pregunta-form">

    <?php $form = ActiveForm::begin([
    'id' => 'Pregunta',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    'fieldConfig' => [
             'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
             'horizontalCssClasses' => [
                 'label' => 'col-sm-2',
                 #'offset' => 'col-sm-offset-4',
                 'wrapper' => 'col-sm-8',
                 'error' => '',
                 'hint' => '',
             ],
         ],
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            

<!-- attribute anyo -->
			<?= $form->field($model, 'anyo')->textInput() ?>

<!-- attribute max_longitud -->
			<?= $form->field($model, 'max_longitud')->textInput() ?>

<!-- attribute orden -->
			<?= $form->field($model, 'orden')->textInput() ?>

<!-- attribute tipo_estudio_id -->
			<?= // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::activeField
$form->field($model, 'tipo_estudio_id')->dropDownList(
    \yii\helpers\ArrayHelper::map(app\models\TipoEstudio::find()->all(), 'id', 'id'),
    [
        'prompt' => 'Select',
        'disabled' => (isset($relAttributes) && isset($relAttributes['tipo_estudio_id'])),
    ]
); ?>

<!-- attribute fase -->
			<?= $form->field($model, 'fase')->textInput() ?>

<!-- attribute descripcion -->
			<?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

<!-- attribute titulo -->
			<?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'Pregunta'),
    'content' => $this->blocks['main'],
    'active'  => true,
],
                    ]
                 ]
    );
    ?>
        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ' .
        ($model->isNewRecord ? 'Create' : 'Save'),
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

