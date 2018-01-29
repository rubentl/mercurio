<?php

namespace app\controllers;

use Yii;
use app\models\Usuarios;
use app\models\Grupos;
use app\models\Roles;
use app\models\Participan;
use app\models\Mensajes;
use app\models\Reciben;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * UsuariosController implements the CRUD actions for Usuarios model.
 */
class UsuariosController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'validar',
                    'create',
                    'delete',
                    'escritorio',
                    'index',
                    'invitar',
                    'nuevo',
                    'update',
                    'view'
                ],
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['validar'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    protected function hasAccess($id){
        return (Yii::$app->user->identity->id == $id 
            || Yii::$app->user->identity->isAdmin());
    }

    protected function isAdmin(){
        return Yii::$app->user->identity->isAdmin();
    }
    /**
     * Lists all Usuarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!yii::$app->user->isGuest){
            return $this->redirect(['escritorio', 'id' => Yii::$app->user->identity->id_usuario]);
        }else{
            return $this->goHome();
        }
    }

    public function actionEscritorio(){
        $id = Yii::$app->request->get('id');
        if ($this->hasAccess($id)){
            $usuario = $this->findModel($id);
            $dataProviderMensajes = new ActiveDataProvider([
                'query'=>$usuario->getRecibens(),
                'sort'=>[
                    'defaultOrder' =>['fecha_recibido'=>SORT_DESC]
                ]
            ]);
            $mensajes_sin_leer = $usuario->mensajesSinLeer();
            if ($mensajes_sin_leer > 0){
                Yii::$app->session->set('escritorio', 'nuevo');
            }
            return $this->render('escritorio',[
                'usuario' => $usuario,
                'usuarios' => Usuarios::find()
                    ->where(['<>','id_usuario',Yii::$app->user->identity->id])
                    ->andWhere(['activo'=> 1])
                    ->all(),
                'grupos' => Grupos::find()->all(),
                'dataProviderMensajes' => $dataProviderMensajes,
                'mensajes_sin_leer' => $mensajes_sin_leer,
            ]);
        }else{
            return $this->goHome();
        }
    }

    /**
     * Displays a single Usuarios model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if ($this->hasAccess($id)){
            $modelo = $this->findModel($id);

            $dataProviderGrupos = new ActiveDataProvider([
                'query' => $modelo->getGrupos(),
            ]);

            $dataProviderMensajes = new ActiveDataProvider([
                'query' => $modelo->getMensajes(),
            ]);
            return $this->render('view', [
                'model' => $modelo,
                'grupos' => $dataProviderGrupos,
                'mensajes' =>$dataProviderMensajes
            ]);
        }else{
            return $this->goHome();
        }
    }

    /**
     * Creates a new Usuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if ($this->isAdmin()){

            $model = new Usuarios();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id_usuario]);
            }
            $roles_tmp = Roles::find()->all();
            foreach ($roles_tmp as $modelo) {
                $roles[$modelo->rol] =  $modelo->rol;
            }
            return $this->render('create', [
                'model' => $model,
                'roles' => $roles
            ]);

        }else{
            $this->goHome();
        }
    }

    /**
     * Updates an existing Usuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if ($this->hasAccess($id)){
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()))  {
            if ($this->isAdmin()){
                $model->save(false);
            }else{
                $model->save();
            }
            if($marcados = $_POST['Usuarios']['grupos']){
                $model->setGrupos($marcados);
            }
            return $this->redirect(['view', 'id' => $model->id_usuario]);
        }
        
        $roles_tmp = Roles::find()->all();
        foreach ($roles_tmp as $modelo) {
            $roles[$modelo->rol] =  $modelo->rol;
        }

        $grupos = ArrayHelper::map(Grupos::find()->all(), 'id_grupo', 'grupo');

        return $this->render('update', [
            'model' => $model,
            'roles' => $roles,
            'grupos' => $grupos,
        ]);

        }else{
            return $this->goHome();
        }
    }

    /**
     * Deletes an existing Usuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if ($this->isAdmin()){
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }else{
            return $this->goHome();
        }
    }

    public function actionNuevo(){
        if ($this->isAdmin()){
            $modelo = new Usuarios();
            if ($post = Yii::$app->request->post()) {
                $modelo->nombre = $post['Usuarios']['nombre'];
                $modelo->email = $post['Usuarios']['email'];
                $modelo->save(false);
                return $this->redirect(['view', 'id' => $modelo->id_usuario]);
            }
            return $this->render('nuevo', [
                'modelo' => $modelo
            ]);
        }else{
            return $this->goHome();
        }
    }

    public function actionValidar($authKey, $id){
        $_id = Html::decode($id);
        $_authKey = Html::decode($authKey);
        $user = $this->findModel($_id);
        $user->passwd = '';
        if ($user->validarUsuario($_authKey)){
            return $this->redirect(['update', 'id'=>$_id]);
        }
        return $this->goHome();
    }

    public function actionInvitar($id){
        if($this->isAdmin()){
            if ($this->findModel($id)->sendCorreo()){
                return $this->redirect(['site/admin']);
            }
            return $this->redirect(['view', 'id'=>$id]);
        }else{
            return $this->goHome();
        }
    }

    /**
     * Finds the Usuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('El usuario que buscas no existe.');
    }
}
