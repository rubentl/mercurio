<?php

namespace app\controllers;

use Yii;
use app\models\Grupos;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GruposController implements the CRUD actions for Grupos model.
 */
class GruposController extends Controller
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
                    'update',
                    'view',
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
     * Lists all Grupos models.
     * @return mixed
     */
    /*public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Grupos::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }*/

    /**
     * Displays a single Grupos model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Grupos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Grupos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_grupo]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
   /* public function actionAdd()
    {
        if ($id = Yii::$app->request->post('id')){
            $participan = new Participan();
            $participan->id_grupo = $id;
            $participan->id_usuario = Yii::$app->request->post('usuario');
            $participan->save(false);
            return $this->goBack();
        }
        
        $usuario = Yii::$app->request->get('id_usuario');
        $grupos = ArrayHelper::map(Grupos::find()->all(), 'id_grupo', 'grupo');

        return $this->render('add', [
            'grupos' => $grupos,
            'usuario' => $usuario
        ]);
   }*/

    /**
     * Updates an existing Grupos model.
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
                return $this->redirect(['view', 'id' => $model->id_grupo]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }else{
            return $this->goHome();
        }
    }

    /**
     * Deletes an existing Grupos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if($this->isAdmin()){
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        }else{
            return $this->goHome();
        }
    }

    /**
     * Finds the Grupos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Grupos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Grupos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Este grupo no existe.');
    }
}
