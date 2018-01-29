<?php

use yii\helpers\Html;
use amass\panel\Panel;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = 'Actualización de Usuario: ';
?>
<div class="usuarios-update">

    <h1><?= Html::encode($this->title) ?></h1>

<?php Panel::begin([
    'headerTitle' => 'Actualizar',
    'footer' => false,
    'type' => Panel::TYPE_INFO
]);
    echo $this->render('_form', [
        'model' => $model,
        'roles' => $roles,
        'grupos' =>$grupos
    ]);
Panel::end();?>

</div>
