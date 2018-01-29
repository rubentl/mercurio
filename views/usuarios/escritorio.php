<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use \amass\panel\Panel;
use yii\data\ActiveDataProvider;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Escritorio Mercurio';
?>
    <h1><?= Html::encode($this->title) ?></h1>
    <h3><?= Html::a(
        Html::tag('span', '', ['class'=>'glyphicon glyphicon-user']) . ' ' .
        $usuario->nombre . ' como ' . $usuario->login,
        ['usuarios/view', 'id'=>$usuario->id_usuario],
        ['class'=>'btn btn-default btn-lg sombra']
) ?></h3>

<?php 

$remitentes = implode(',', array_unique(ArrayHelper::map(
    $usuario->getRecibens()->where(['fecha_leido'=>null])->all(),
    'id_mensaje','mensaje.origen.nombre')));

$content = ($mensajes_sin_leer > 0) 
    ? Html::tag('p', $mensajes_sin_leer . ' mensaje(s) sin leer de '. $remitentes)
    : Html::tag('p', 'No tienen mensajes sin leer');

?>

<div class="row">
<div class="col-xs-12 col-md-2">

<?php 
Panel::begin([
    'headerTitle' => 'Personas',
    'footer' => false,
    'type' => Panel::TYPE_INFO
]);
echo $this->render('_usuarios',
    [
        'usuario'=>$usuario,
        'usuarios'=>$usuarios
    ]); 
Panel::end();
?>
    </div>
    <div class="col-xs-12 col-md-8">
<?php 
Panel::begin([
    'headerTitle' => 'Mensajes',
    'footer' => false,
    'type' => Panel::TYPE_SUCCESS
]);
echo $this->render('_mensajes',
    [
        'usuario'=>$usuario,
        'dataProviderMensajes' => $dataProviderMensajes,
    ]); 
Panel::end();
?>
    </div>
    <div class="col-xs-12 col-md-2">
<?php
Panel::begin([
    'headerTitle' => 'Grupos',
    'footer' => false,
    'type' => Panel::TYPE_INFO
]);
echo $this->render('_grupos',
    [
        'usuario'=>$usuario,
        'grupos' => $grupos
    ]); 
Panel::end();
?>
    </div>
</div>

<?php

if (Yii::$app->session->get('escritorio') ==='nuevo'){
    Modal::begin([
        'id' => 'numeroMensajes',
    ]);
    echo Panel::widget([
        'headerTitle' => 'Mensajes',
        'content' => $content,
        'footer' => false,
        'type' => Panel::TYPE_PRIMARY,
    ]);
    Modal::end();
    $this->registerJs('
        $("#numeroMensajes").modal("show");
    ');
    Yii::$app->session->set('escritorio','viejo');
}
