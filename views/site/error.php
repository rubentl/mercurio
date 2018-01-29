<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use amass\panel\Panel;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

<?php Panel::begin([
    'headerTitle' => 'Error',
    'footer' => false,
    'type' => Panel::TYPE_WARNING
]);?>
    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Ha ocurrido un error mientras el servidor web estaba intentando procesar tu petición.
    </p>
    <p>
        Por favor, contacta con nosotros si crees que esun error del servidor.
    </p>
<p>Gracias</p>

<?php Panel::end();?>
</div>
