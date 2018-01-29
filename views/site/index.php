<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'Mercurio mensajería';
?>
<div class="site-index container">

    <div class="body-content row">
    
        <div class="col-xs-12 col-sm-6 jumbotron">
            <h1>Mercurio</h1>
            <p class="lead text-center">Sistema de mensajería para tu Empresa.</p>
         </div>

        <div class="col-sm-6 col-xs-12">
            <div class="thumbnail">
                 <img src=<?= Url::to("@web/imgs/mercurio.jpg")?> alt="mercurio el mensajero de los dioses">
            </div>
        </div>
    </div>


</div>
