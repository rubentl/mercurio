<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use amass\panel\Panel;

/* @var $this yii\web\View */
/* @var $model app\models\Grupos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grupos-form col-xs-12 col-sm-6 col-sm-offset-3">

<?php Panel::begin([
    'headerTitle' => 'Grupo',
    'footer' => false,
    'type' => Panel::TYPE_INFO
]);?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'grupo')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

<?php Panel::end();?>
</div>
