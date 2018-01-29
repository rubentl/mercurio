<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Roles;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuarios-form col-xs-12 col-sm-6 col-sm-offset-3">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelo, 'nombre')->textInput(['maxlength' => true]) ?>
    <?= $form->field($modelo, 'email')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
