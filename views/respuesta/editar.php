<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;


/**
* @var yii\web\View $this
* @var app\models\Respuesta $model
*/

$this->title = Yii::t('models', 'Respuesta');
?>
<div class="giiant-crud respuesta-update">

    <?php     $form = ActiveForm::begin([
        'id' => 'respuesta',
        'layout' => 'default',
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

    ?>

 
    <?php echo Html::activeHiddenInput($model, "pregunta_id")."\n";
        echo Html::activeHiddenInput($model, "propuesta_id")."\n";
        echo $form->field($model, "valor")
            ->label('<h2>'.Html::encode($model->pregunta->titulo).'</h2>')
            ->hint(Html::encode($model->pregunta->descripcion))
            ->textarea(['maxlength' => $model->pregunta->max_longitud, 'rows' => 6])."\n\n";

        echo Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> '.
                Yii::t('jonathan', 'Guardar'),
            [
                'id' => 'save-' . $model->formName(),
                'class' => 'btn btn-success',
            ]
        );
        
        ActiveForm::end();
        
    ?>

</div>
