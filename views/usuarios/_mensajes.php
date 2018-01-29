<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\bootstrap\Modal;


echo GridView::widget([
    'dataProvider' => $dataProviderMensajes,
    'summary' => 'Viendo {begin} - {count} de {totalCount}',
    'columns' => [
        [
            'header' => 'Resumen',
            'attribute' => 'mensaje.contenido',
            'format' => 'text',
            'value' => function($model){
                return $model->mensaje->resumen(30);
            }
        ],
        [
            'header' => 'Remitente',
            'attribute' => 'mensaje.origen.nombre'
        ],
        'mensaje.fecha:datetime',
        'mensaje.prioridad',
        [
            'header' =>'',
            'format' => 'raw',
            'value'=> function($model){
                $classBoton = (empty($model->fecha_leido)) ? "btn-danger" : "btn-primary";
                return Html::a(
                    'Leer',
                    ['mensajes/leer', 'id'=>$model->id_mensaje],
                    ['class' => "btn " . $classBoton . " pull-right"]
                );
            }
        ],
    ],     
]);
