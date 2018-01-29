<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Mensajes */

$this->title = 'Actualizar';
?>
<div class="mensajes-update row">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
