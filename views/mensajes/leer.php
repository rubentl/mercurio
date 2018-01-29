<div class="row">
    <div class="col-xs-12 col-sm-6 col-sm-offset-3">

<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use amass\panel\Panel;


Panel::begin([
    'headerTitle' => 'Mensaje',
    'type' => Panel::TYPE_INFO
]);
echo $model->fecha . '<br><hr>';
echo Html::encode($model->contenido);
echo '<hr>';
echo Html::a(
    'Cerrar',
    ['usuarios/escritorio','id'=>Yii::$app->user->id],
    ['class'=>'btn btn-default pull-right']
);
Panel::end();

?>
    </div>
</div>
