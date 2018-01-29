<?php

use yii\helpers\Html;
use amass\panel\Panel;

/* @var $this yii\web\View */
/* @var $model app\models\Mensajes */

$this->title = 'Nuevo mensaje';
?>
<div class="mensajes-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->session->hasFlash('mensajeEnviado')): ?>


<?php
Panel::begin([
    'headerTitle' => 'Grupos',
    'footer' => false,
    'type' => Panel::TYPE_INFO
]);
echo 'Tu mensaje ha sido enviado con éxito.';
Panel::end();
?>
    <?php else: ?>

    <?= $this->render('_form', [
        'model' => $model,
        'prioridades' => $prioridades,
    ]) ?>

    <?php endif; ?>
</div>
