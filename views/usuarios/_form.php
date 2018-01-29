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

    <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>

<?php 
if (!Yii::$app->user->identity->isAdmin()){
    echo $form->field($model, 'passwd')->passwordInput(['maxlength' => true]);
    echo $form->field($model, 'passwd_repeat')->passwordInput(['maxlength' => true]); 
}?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    <?php if (Yii::$app->user->identity->isAdmin()){
        echo $form->field($model, 'rol')->dropDownList($roles);
        echo $form->field($model, 'activo')->dropDownList(['no','sí']);
    }?>
    <?= $form->field($model, 'grupos')->dropDownList($grupos,['multiple'=>true]) ?>
    

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
