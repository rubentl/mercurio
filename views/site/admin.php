<?php


use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use amass\panel\Panel;
use app\models\Usuarios;
use app\models\Mensajes;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Zona administrativa';
?>
    <h1><?= Html::encode($this->title) ?></h1>

<?php 

$content = ($mensajes_sin_leer > 0) 
    ? Html::tag('p', $mensajes_sin_leer . ' mensaje(s) sin leer de '. $remitentes)
    : Html::tag('p', 'No tienen mensajes sin leer.');
$content .= Html::tag(
    'p',
    "Hay <strong>$usuarios_totales</strong> usuarios de los cuales <strong>$usuarios_no_activos</strong> están sin activar: $no_activos_nombres."
);
$content .= Html::tag(
    'p',
    "Hay <strong>$mensajes_totales</strong> mensajes en el sistema de los cuales <strong>$mensajes_no_leidos</strong> están aún sin leer."
);

echo Panel::widget([
    'headerTitle' => 'Información',
    'content' => $content,
    'footer' => false,
    'type' => Panel::TYPE_WARNING,
]);
?>

<div class="row">

<div class="usuarios-index col-xs-12 col-md-9">
<h2>Usuarios</h2>
    <p>
        <?= Html::a('Crear nuevo usuario', ['usuarios/nuevo'], ['class' => 'btn btn-success']) ?>
    </p>

<?php
    Panel::begin([
    'headerTitle' => 'Usuarios',
    'footer' => false,
    'type' => Panel::TYPE_INFO
]); 
    echo GridView::widget([
        'dataProvider' => $dataProviderUsuarios,
        'filterModel' => $searchUsuario,
        'summary' => 'Viendo {begin} - {count} de {totalCount}',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id_usuario',
            'nombre',
            'email:email',
            'rol',
            'activo',
            [
                'attribute' => 'Grupos',
                'format' => 'text',
                'value' => function($model){
                    return implode(',', ArrayHelper::map($model->grupos,'id_grupo','grupo')); 
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' =>'Acciones',
                'template' => '{ver}{modificar}{borrar}{invitar}',
                'buttons' => [
                    'ver' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['usuarios/view', 'id' => $model->id_usuario]);
                    },
                    'modificar' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['usuarios/update', 'id' => $model->id_usuario]);
                    },
                    'borrar' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['usuarios/delete', 'id' => $model->id_usuario], ['data-confirm'=>'¿estás seguro de que quieres borrarlo?','data-method'=>'post']);
                    },
                    'invitar' => function ($url, $model){
                        if ($model->activo === 0){
                            return Html::a('<span class="glyphicon glyphicon-send"></span>', ['usuarios/invitar', 'id'=>$model->id_usuario]);
                        }else{
                            return null;
                        }
                    },
                ],
        ],
        ],
    ]); 
Panel::end();
?>
</div>
<div class="grupos-index col-xs-12 col-md-3">
<h2>Grupos</h2>
    <p>
        <?= Html::a('Crear nuevo grupo', ['grupos/create'], ['class' => 'btn btn-success']) ?>
    </p>

<?php
    Panel::begin([
    'headerTitle' => 'Grupos',
    'footer' => false,
    'type' => Panel::TYPE_INFO
]); 

echo GridView::widget([
        'dataProvider' => $dataProviderGrupos,
        'filterModel' => $searchGrupo,
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
        ],
    ]); 
Panel::end();
?>
</div>
</div>
<div class="row">
    <div class="col-xs-12 ">
    <h2>Mensajes</h2>
    <p>
        <?= Html::a('Crear nuevo mensaje', ['mensajes/create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php
    Panel::begin([
    'headerTitle' => 'Mensajes',
    'footer' => false,
    'type' => Panel::TYPE_INFO
]); 
echo GridView::widget([
        'dataProvider' => $dataProviderMensajes,
        'filterModel' => $searchMensaje,
        'summary' => 'Viendo {begin} - {count} de {totalCount}',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_mensaje',
            'origen.nombre',
            'contenido',
            'fecha',
            [
                'attribute' => 'Recibens',
                'header' => 'Destino',
                'format' => 'html',
                'value' => function($model){
                    return implode(',', ArrayHelper::map($model->recibens,'id_usuario','usuario.nombre')); 
                }
            ],
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
        ],
    ]); 
Panel::end();
?>
    </div>
</div>
