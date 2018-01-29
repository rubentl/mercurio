<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Usuarios;
use app\models\Grupos;
use app\models\Mensajes;
use app\models\Prioridades;
use app\models\Reciben;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','admin'],
                'rules' => [
                    [
                        'actions' => ['logout','admin'],
                        'allow' => true,
                        'roles' => ['@'],
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

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->user->identity->recibirMensajes();
            if (Yii::$app->user->identity->isAdmin()){
                return $this->redirect('admin');
            }else{
                return $this->redirect(
                    [
                        'usuarios/escritorio', 
                        'id'=> Yii::$app->user->identity->id
                    ]);
            }
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        Yii::$app->session->set('escritorio','nuevo');

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAyuda()
    {
        return $this->render('ayuda');
    }

    public function actionAdmin()
    {
        if (Yii::$app->user->identity->isAdmin()){
            $searchUsuario = new Usuarios();
            $dataProviderUsuarios = $searchUsuario->search(Yii::$app->request->queryParams);
            $dataProviderUsuarios->setSort([
                    'attributes'=>[
                        'activo' =>[
                            'default' => SORT_ASC
                        ]
                    ]
                ]);
            $searchGrupo = new Grupos();
            $dataProviderGrupos = $searchGrupo->search(Yii::$app->request->queryParams);

            $searchMensaje = new Mensajes();
            $dataProviderMensajes = $searchMensaje->search(Yii::$app->request->queryParams);

            $usuario = Yii::$app->user->identity;

            $remitentes = implode(',', array_unique(ArrayHelper::map(
                $usuario->getRecibens()->where(['fecha_leido'=>null])->all(),
                'id_mensaje','mensaje.origen.nombre')));
            $no_activos_nombres = implode(',', ArrayHelper::map(
                Usuarios::find()->where(['activo'=>0])->all(),
                'id_usuario','nombre'));

            $usuarios_totales = Usuarios::find()->count();
            $usuarios_no_activos = Usuarios::find()->where(['activo'=>0])->count();
            $mensajes_totales = Mensajes::find()->count();
            $mensajes_no_leidos = Reciben::find()->where(['fecha_leido'=>null])->count();

            return $this->render('admin',[
                'dataProviderUsuarios' => $dataProviderUsuarios,
                'searchUsuario' => $searchUsuario,
                'dataProviderGrupos' =>$dataProviderGrupos,
                'searchGrupo' => $searchGrupo,
                'dataProviderMensajes' =>$dataProviderMensajes,
                'searchMensaje' => $searchMensaje,
                'usuario' => $usuario,
                'mensajes_sin_leer' => $usuario->mensajesSinLeer(),
                'remitentes' => $remitentes,
                'usuarios_totales' => $usuarios_totales,
                'usuarios_no_activos' => $usuarios_no_activos,
                'mensajes_totales' => $mensajes_totales,
                'mensajes_no_leidos' => $mensajes_no_leidos,
                'no_activos_nombres' => $no_activos_nombres,
            ]);
        }
        return $this->goHome();
    }

}
