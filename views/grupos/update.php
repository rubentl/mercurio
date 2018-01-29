<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Grupos */

$this->title = 'Actualizar Grupo';
?>
<div class="grupos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
