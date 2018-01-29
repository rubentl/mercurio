<?php

use yii\helpers\Html;

echo Html::a(
    'Todos',
    ['mensajes/create', 'todos' => 'grupos'],
    ['class' => 'btn btn-default btn-lg col-xs-12 botonUsuario']
);
foreach ($grupos as $grupo) {
    echo Html::a(
        $grupo->grupo, 
        [
            'mensajes/create', 
            'grupo'=>$grupo->id
        ],
        [
            'class' => 'btn btn-info btn-lg col-xs-12 botonUsuario'
        ]
    );
}
