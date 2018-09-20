<?php

use yii\helpers\Html;
use app\models\Estado;

$this->title = $propuesta->denominacion;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Gestión'), 'url' => ['//gestion/index']];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('models', 'Valoraciones individuales'),
    'url' => ['//gestion/propuesta-evaluador/valoraciones', 'anyo' => $propuesta->anyo]
];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?php echo Html::a(
    $propuesta->denominacion,
    ['//gestion/propuesta/ver', 'id' => $propuesta->id],
    ['target' => '_blank']
); ?></h1>
<hr><br>

<!-- ⸻⸻⸻⸻⸻⸻⸻⸻⸻ Puntuaciones de los bloques ⸻⸻⸻⸻⸻⸻⸻⸻⸻ -->

<h2><?php echo Yii::t('gestion', 'Puntuaciones'); ?></h2>

<div class='table-responsive cabecera-azul'>
<table class='table table-striped table-hover'>
  <thead>
    <tr>
      <th><?php echo Yii::t('gestion', 'Bloque'); ?></th>
      <th><?php echo Yii::t('gestion', 'Puntuación'); ?></th>
    </tr>
  </thead>
  <tbody>
<?php
foreach ($valoraciones as $valoracion) {
    if (!$valoracion->bloque->tiene_puntuacion_interna) {
        echo "  <tr>\n";
        echo "    <td>{$valoracion->bloque->titulo}</td>\n";
        echo '    <td>' . Yii::$app->formatter->asDecimal($valoracion->puntuacion, 1) . "</td>\n";
        echo "  </tr>\n";
    }
}
?>
    <tfoot><tr>
      <td><?php echo Yii::t('gestion', 'Puntuación final'); ?></td>
      <td><?php
        echo Yii::$app->formatter->asDecimal(
            array_sum(
                array_map(
                    function ($valoracion) {
                        return ($valoracion->bloque->porcentaje / 100) * $valoracion->puntuacion;
                    },
                    $valoraciones
                )
            ),
            2
        );
        ?></td>
    </tr></tfoot>
  </tbody>
</table>
</div>


<!-- ⸻⸻⸻⸻⸻⸻⸻⸻⸻ Comentarios de los bloques ⸻⸻⸻⸻⸻⸻⸻⸻⸻ -->

<h2><?php echo Yii::t('jonathan', 'Comentarios'); ?></h2>

<?php
foreach ($valoraciones as $valoracion) {
            echo "<h3>{$valoracion->bloque->titulo}</h3>\n";
            echo "<p style='font-weight: bold;'>" . nl2br(Html::encode($valoracion->bloque->descripcion)) . "</p>\n\n";
            echo '<p>' . nl2br(Html::encode($valoracion->comentarios)) . "</p>\n\n";
        }

if (Estado::VALORACION_PRESENTADA == $asignacion->estado_id) {
    echo Html::a(
        '<span class="glyphicon glyphicon-remove"></span> &nbsp;' . Yii::t('jonathan', 'Devolver al evaluador'),
        ['//gestion/propuesta-evaluador/abrir', 'id' => $asignacion->id],
        [
            'id' => 'devolver',
            'class' => 'btn btn-danger',
            'title' => Yii::t(
                'jonathan',
                "La evaluación está incompleta.\nVolverla a poner en estado Pendiente de evaluación para su corrección."
            ),
        ]
    ) . "\n\n";
}
