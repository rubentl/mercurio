<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use amass\panel\Panel;

$this->title = 'Acceso';
?>
<div class="row site-login">
<div class="col-sm-6 col-sm-offset-3 col-xs-12">

<?php Panel::begin([
    'headerTitle' => 'Login',
    'footer' => false,
    'type' => Panel::TYPE_INFO
]);?>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Rellena el formulario para acceder al sistema:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-sm-8\">{input}</div>\n<div class=\"col-sm-8 col-sm-offset-4\">{error}</div>",
            'labelOptions' => ['class' => 'col-sm-4 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-sm-offset-1 col-sm-7\">{input} {label}</div>\n<div class=\"col-sm-12\">{error}</div>",
        ]) ?>

        <div class="form-group">
            <div class="col-lg-offset-8 col-lg-4 col-xs-12">
                <?= Html::submitButton('Entrar', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); 
Panel::end();?>
</div>
</div>
