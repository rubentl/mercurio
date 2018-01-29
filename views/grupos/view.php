<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use amass\panel\Panel;

/* @var $this yii\web\View */
/* @var $model app\models\Grupos */

$this->title = $model->grupo;
?>
<div class="grupos-view">

    <h1><?= Html::encode($this->title) ?></h1>

<?php Panel::begin([
    'headerTitle' => 'Grupo',
    'footer' => false,
    'type' => Panel::TYPE_INFO
]);?>
    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id_grupo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->id_grupo], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estás seguro que quieres borrarlo?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_grupo',
            'grupo',
        ],
    ]);

Panel::end();?>

</div>
