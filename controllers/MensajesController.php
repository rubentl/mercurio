<?php

namespace app\controllers;

use Yii;
use app\models\Mensajes;
use app\models\Reciben;
use app\models\Prioridades;
use app\models\Usuarios;
use yii\filters\AccessControl;
use app\models\Grupos;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * MensajesController implements the CRUD actions for Mensajes model.
 */
class MensajesController extends Controller
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
                    'create',
                    'delete',
                    'leer',
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
                        'actions' => [],
                        'allow' => false,
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
     * Lists all Mensajes models.
     * @return mixed
     */
    /*public function actionIndex()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => Mensajes::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }*/

    /**
     * Displays a single Mensajes model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if ($this->hasAccess($id)){
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }else{
            return $this->goHome();
        }
    }

    /**
     * Creates a new Mensajes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Mensajes();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('mensajeEnviado');
            if (isset($_GET['destino'])){
                $destino = Usuarios::find()
                    ->where(['id_usuario'=>$_GET['destino'],'activo'=>1])
                    ->one();
                $model->enviar([$destino]);

            }else if(isset($_GET['grupo'])){
                $grupo = Grupos::find()
                    ->where(['id_grupo'=>$_GET['grupo']])
                    ->one();
                $model->enviar($grupo->usuarios);

            }else if(isset($_GET['todos'])){
                if($_GET['todos'] === 'usuarios'){
                    $usuarios = Usuarios::find()
                        ->where(['activo'=>1])
                        ->andWhere(['<>','id_usuario',Yii::$app->user->identity->id])
                        ->all();
                    $model->enviar($usuarios);
                }else if ($_GET['todos'] == 'grupos'){
                    $grupos = Grupos::find()->all();
                    foreach($grupos as $grupo){
                        $model->enviar($grupo->getUsuarios()
                            ->where(['activo'=>1])
                            ->andWhere(['<>','id_usuario',Yii::$app->user->identity->id])
                        );
                    }
                }
            }
            return $this->refresh();
        }

        return $this->render('create', [
            'model' => $model,
            'prioridades'=> ArrayHelper::map(Prioridades::find()->all(), 'prioridad', 'prioridad'),
        ]);
    }

    public function actionLeer($id){
        $mensaje = $this->findModel($id);
        $id_usuario = Yii::$app->user->identity->id;
        $mensaje->getRecibens()->where([
            'id_mensaje' => $id,
            'id_usuario' => $id_usuario
        ])->one()->mensajeLeido();
        return $this->render('leer',[
            'model' => $mensaje
        ]);
    }

    /**
     * Updates an existing Mensajes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if($this->isAdmin()){
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id_mensaje]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }else{
            return $this->goHome();
        }
    }

    /**
     * Deletes an existing Mensajes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if($this->isAdmin()){
            $this->findModel($id)->delete();

            return $this->redirect(['site/admin']);
        }else{
            return $this->goHome();
        }
    }

    /**
     * Finds the Mensajes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mensajes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mensajes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('El mensaje solicitado no existe.');
    }
}
