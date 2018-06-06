<?php
use app\models\User;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<div class="user-form">

    <?php
    $form = ActiveForm::begin([
        'id' => 'User',
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
        'options' => ['enctype' => 'multipart/form-data'],
    ]);

    $profile = new \Da\User\Model\Profile();
    echo $form->field($model, 'username', ['inputOptions' => ['placeholder' => 'perico.palotes']])
        ->textInput(['maxlength' => true])->hint(Yii::t('jonathan', 'Nombre de usuario con el que iniciar sesión'));
    echo $form->field($model, 'email', ['inputOptions' => ['placeholder' => 'perico@palotelandia.es']])
        ->textInput(['maxlength' => true]);
    echo $form->field($model, 'password', ['inputOptions' => ['placeholder' => 'AbreteSesamo']])->textInput();
    echo $form->field($profile, 'name', ['inputOptions' => ['placeholder' => 'Perico de los Palotes']])
        ->textInput(['maxlength' => true])->hint(Yii::t('jonathan', 'Nombre y apellidos del usuario')); ?>

    <hr>

    <?php
    echo $form->errorSummary($model) . "\n";

    echo "<div class='form-group'>\n";
    echo Html::a(
        Yii::t('jonathan', 'Cancelar'),
        Yii::$app->request->referrer,
        ['class' => 'btn btn-default']
    ) . "&nbsp;\n&nbsp;";

    echo Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ' . Yii::t('jonathan', 'Guardar'),
        [
            'id' => 'save-' . $model->formName(),
            'class' => 'btn btn-success',
        ]
    ) . "\n";
    echo "</div>\n";

    ActiveForm::end();
    ?>
</div>

