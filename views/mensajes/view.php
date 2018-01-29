<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use amass\panel\Panel;

/* @var $this yii\web\View */
/* @var $model app\models\Mensajes */

$this->title = $model->origen->nombre;
?>
<div class="mensajes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id_mensaje], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->id_mensaje], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estás seguro de que quieres borrarlo?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

<?php Panel::begin([
    'headerTitle' => 'Mensaje',
    'footer' => false,
    'type' => Panel::TYPE_INFO
]);?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_mensaje',
            'origen.nombre',
            'contenido:ntext',
            'fecha',
            'prioridad',
        ],
    ]);

Panel::end();?>

</div>
