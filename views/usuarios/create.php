<?php

use yii\helpers\Html;
use amass\panel\Panel;


/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = 'Crear usuario';
?>
<div class="usuarios-create row">

    <h1><?= Html::encode($this->title) ?></h1>

<?php Panel::begin([
    'headerTitle' => 'Usuario',
    'footer' => false,
    'type' => Panel::TYPE_INFO
]);
    echo $this->render('_form', [
        'model' => $model,
        'roles' => $roles
    ]);

Panel::end();
?>

</div>
