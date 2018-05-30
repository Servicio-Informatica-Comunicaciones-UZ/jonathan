<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

?>

<h2>Propuesta presentada</h2>

<p>Ha presentado correctamente la propuesta «<strong><?php echo $denominacion; ?></strong>»,
que se envía adjunta a modo de resguardo.</p>

<p>Por favor, no responda a este mensaje, pues ha sido enviado por una máquina.</p>

<p>Para cualquier cuestión, contacte con la Dirección de Organización Académica
    &lt;<?php echo Html::mailto('diroa@unizar.es', 'diroa@unizar.es'); ?>&gt;.</p>

<p>Un cordial saludo<br>
 &nbsp; El/La Vicerrector/a de Política Académica</p>