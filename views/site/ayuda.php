<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\Collapse;

$this->title = 'Ayuda';
?>
<div class="site-about">

    <div class="row">
       <div class="col-md-6 col-md-offset-3">
    <h1><?= Html::encode($this->title) ?></h1>
<?php
echo Collapse::widget([
    'items' => [
        [
            'label' => 'Sobre Mercurio',
            'content' => 'Mercurio, mensajería intranet, es una aplicación que pretende proporcionar un sistema ágil, versátil y fácil de usar para la comunicación entre los usuarios del sistema.',
            'contentOptions' => ['class' => 'in'],
        ],
        [
            'label' => 'Sobre Cómo usar Mercurio',
            'content' => ['Al ser una aplicación exclusivamente interna, no permite el registro sin una invitación previa del administrador de la aplicación.',
            'Para ello, recibirás un correo con un enlace que te permirá acceder al sistema. Una vez dentro tendrás que escoger un nombre de usuario y una contraseña que te servirán en adelante para poder acceder a la aplicación.',
            'Para cualquier duda puedes hacer uso de nuestro formulario de contacto en el menú. '
            ],
        ],
        [
            'label' => 'Sobre Nosotros',
            'content' => [
                'Un proyecto para el curso de Academia Alpe Programación en entornos web',
                'ENCAN'
            ],
        ],
    ]
]);
?>
        </div>
    </div>

</div>
