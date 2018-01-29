<?php

use yii\helpers\Html;
echo Html::a(
    'Todos',
    ['mensajes/create', 'todos' => 'usuarios'],
    ['class' => 'btn btn-default btn-lg col-xs-12 botonUsuario']
);
foreach ($usuarios as $user) {
    echo Html::a(
        $user->nombre, 
        [
            'mensajes/create', 
            'destino'=>$user->id
        ],
        [
            'class' => 'btn btn-info btn-lg col-xs-12 botonUsuario'
        ]
    );
}
