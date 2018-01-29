<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use amass\panel\Panel;

$this->title = 'Contacto';
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): 

        Panel::begin([
            'headerTitle' => 'Grupos',
            'footer' => false,
            'type' => Panel::TYPE_INFO
        ]);
        echo 'Gracias por contactar con nosotros. En breve nos pondremos en contacto contigo.';
        Panel::end();?>

    <?php else: ?>

        <p class='text-center'>
Utiliza este formulario para transmitirnos tus dudas, sugerirnos ideas o ponerte en contacto con nosotros para lo que necesites. Gracias
        </p>

        <div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-offset-3">

<?php Panel::begin([
    'headerTitle' => 'Login',
    'footer' => false,
    'type' => Panel::TYPE_INFO
]);?>
                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'email') ?>

                    <?= $form->field($model, 'subject') ?>

                    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary pull-right', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

<?php Panel::end();?>

            </div>
        </div>

    <?php endif; ?>
</div>
