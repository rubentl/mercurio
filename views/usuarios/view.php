<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use amass\panel\Panel;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = $model->nombre;
$admin = Yii::$app->user->identity->isAdmin();
?>
<div class="usuarios-view row">

    <h1><?= Html::encode($this->title) ?></h1>
<div class="col-xs-12 col-sm-8">
<h2>Usuario</h2>
    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id_usuario], ['class' => 'btn btn-primary']) . ' ' ?>
<?php
if ($admin){
    echo Html::a('Borrar',
        ['delete', 'id' => $model->id_usuario], 
        [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estás seguro que quieres borrarlo?',
                'method' => 'post',
            ],
        ]) . ' ';
    if (!$model->isActivo()){
        echo Html::a('Invitar', 
            ['invitar', 'id'=>$model->id_usuario],
            ['class'=>'btn btn-info']) . ' '; 
    }        
}?>
    </p>


<?php Panel::begin([
    'headerTitle' => 'Usuario',
    'footer' => false,
    'type' => Panel::TYPE_INFO
]);?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_usuario',
            'login',
            'passwd',
            'email:email',
            'nombre',
            'rol',
            'activo',
        ],
    ]); 
Panel::end();?>
</div>
<div class="col-xs-12 col-sm-4">
<h2>Sus grupos</h2>

<?php Panel::begin([
    'headerTitle' => 'Grupos',
    'footer' => false,
    'type' => Panel::TYPE_INFO
]);?>
<?php 
    if (!$admin){
        echo GridView::widget([
            'dataProvider' => $grupos,
            'summary' => 'Viendo {begin} - {count} de {totalCount}',
            'columns' => [
                ['class'=>'yii\grid\SerialColumn'],
                'grupo'
            ]
        ]);
    } else {
        echo GridView::widget([
            'dataProvider' => $grupos,
            'summary' => 'Viendo {begin} - {count} de {totalCount}',
            'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'grupo',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' =>'Acciones',
                        'template' => '{ver}{modificar}{borrar}',
                        'buttons' => [
                            'ver' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['grupos/view', 'id' => $model->id_grupo]);
                            },
                            'modificar' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['grupos/update', 'id' => $model->id_grupo]);
                            },
                            'borrar' => function ($url, $model) {

                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['grupos/delete', 'id' => $model->id_grupo], ['data-confirm'=>'¿estás seguro de que quieres borrarlo?','data-method'=>'post']);
                            },
                        ],
                    ],

                ]
            ]);
    }

Panel::end();
?>
</div>
</div>
<div class="row">
    <div class="col-xs-12">
        <h2>Sus mensajes</h2>  

<?php Panel::begin([
    'headerTitle' => 'Mensajes',
    'footer' => false,
    'type' => Panel::TYPE_INFO
]);?>
<?php 
if (!$admin){
    echo GridView::widget([
        'dataProvider' => $mensajes,
        'summary' => 'Viendo {begin} - {count} de {totalCount}',
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id_mensaje',
                'contenido',
                'fecha',
                'prioridad',
        
            ]
        ]);
}else{

    echo GridView::widget([
        'dataProvider' => $mensajes,
        'summary' => 'Viendo {begin} - {count} de {totalCount}',
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id_mensaje',
                'contenido',
                'fecha',
                'prioridad',
                [
                    'header' => 'Acciones',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{ver}{modificar}{borrar}',
                    'buttons' => [
                        'ver' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['mensajes/view', 'id' => $model->id_mensaje]);
                        },
                        'modificar' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['mensajes/update', 'id' => $model->id_mensaje]);
                        },
                        'borrar' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['mensajes/delete', 'id' => $model->id_mensaje], ['data-confirm'=>'¿estás seguro de que quieres borrarlo?','data-method'=>'post']);
                        },
                    ],
            ],
            ]
        ]);
}

Panel::end();?>
    </div>
</div>
