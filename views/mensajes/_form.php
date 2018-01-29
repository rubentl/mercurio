<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use amass\panel\Panel;

/* @var $this yii\web\View */
/* @var $model app\models\Mensajes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mensajes-form col-xs-12 col-sm-6 col-sm-offset-3">

<?php Panel::begin([
    'headerTitle' => 'Mensaje',
    'footer' => false,
    'type' => Panel::TYPE_INFO
]);?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'contenido')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'prioridad')->dropDownList($prioridades) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

<?php Panel::end();?>
</div>
