<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use app\models\Participan;
use app\models\Grupos;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id_usuario
 * @property string $login
 * @property string $passwd
 * @property string $email
 * @property string $nombre
 * @property string $rol
 * @property int $activo
 *
 * @property Mensajes[] $mensajes
 * @property Participan[] $participans
 * @property Grupos[] $grupos
 * @property Reciben[] $recibens
 * @property Mensajes[] $mensajes0
 * @property Roles $rol0
 */
class Usuarios extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $passwd_repeat;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activo'], 'integer'],
            [['login'], 'string', 'max' => 127],
            [['email', 'nombre'], 'string', 'max' => 127],
            [['passwd'], 'string', 'max' => 255],
            [['rol'], 'string', 'max' => 15],
            [['login'], 'unique'],
            [['rol'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::className(), 'targetAttribute' => ['rol' => 'rol']],
            [['login', 'passwd', 'passwd_repeat'], 'required', 'message' => 'El campo {attribute} es obligatorio'],
            // que el usuario no exista
            ['login', 'unique', 'message' => 'El usuario ya existe en el sistema'],
            ['passwd', 'string', 'min' => 4, 'message' => 'la contraseña debe tener al menos 6 caracteres'],
            //comparacion de contraseñas
            ['passwd_repeat', 'validatePassword', 'message' => 'Las contraseñas deben coincidir'],
            //colocar los campos que necesito que pase en la asignacion masiva
            [[ 'passwd', 'login' ], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_usuario' => 'Id Usuario',
            'login' => 'Nombre de Usuario en el sistema',
            'passwd' => 'Contraseña',
            'passwd_repeat' => 'Repite la contraseña',
            'email' => 'Email',
            'nombre' => 'Nombre personal',
            'rol' => 'Rol',
            'activo' => 'Activo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMensajes()
    {
        return $this->hasMany(Mensajes::className(), ['id_origen' => 'id_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipans()
    {
        return $this->hasMany(Participan::className(), ['id_usuario' => 'id_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrupos()
    {
        return $this->hasMany(Grupos::className(), ['id_grupo' => 'id_grupo'])->viaTable('participan', ['id_usuario' => 'id_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecibens()
    {
        return $this->hasMany(Reciben::className(), ['id_usuario' => 'id_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMensajes0()
    {
        return $this->hasMany(Mensajes::className(), ['id_mensaje' => 'id_mensaje'])->viaTable('reciben', ['id_usuario' => 'id_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRol0()
    {
        return $this->hasOne(Roles::className(), ['rol' => 'rol']);
    }


    public static function findIdentity($id) {
        return static::findOne(['id_usuario' => $id]);
    }

    public static function findByUsername($username) {
        return static::findOne(['login' => $username]);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id_usuario;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return md5($this->email . $this->nombre);
    }

    
    public function setPasswd(){
        $this->passwd = md5($this->passwd);
    }
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        //return Yii::$app->getSecurity()->validatePassword($password, $this->passwd);
        return $this->passwd === md5($password);
    }


    public function codeVerify($attribute) {
        /* nombre de la accion del controlador */
        $captcha_validate = new  \yii\captcha\CaptchaAction('captcha', Yii::$app->controller);
        
        
        if ($this->$attribute) {
            $code = $captcha_validate->getVerifyCode();
            if ($this->$attribute != $code) {
                $this->addError($attribute, 'Ese codigo de verificacion no es correcto');
            }
        }        
    }

    public function isActivo(){
        return $this->activo === 1;
    }

    public function isAdmin(){
        return 'admin' === $this->rol;
    }

    public function isValidAuthKey($key){
        return $key === $this->getAuthKey();
    }

    public function setGrupos(Array $ids){
        $olds = $this->getGrupos()->asArray()->column();
        $nuevos = array_diff($ids, $olds);
        $this->removeGrupos(array_diff($olds, $ids));
        $grupos = Grupos::find()->asArray()->column();
        foreach ($nuevos as $id) {
            if (in_array($id, $grupos)){
                $participa =  new Participan();
                $participa->id_usuario = $this->getId();
                $participa->id_grupo = $id;
                $participa->save();
            }
        }
    }

    public function removeGrupos(Array $quitar){       
        foreach($quitar as $id){
            (Participan::find()->where(
                [
                    'id_usuario' => $this->getId(),
                    'id_grupo' => $id 
                ])->one()->delete());
        }
    }

    public function validarUsuario($key){
        $result = false;
        if ($this->isValidAuthKey($key)){
            $this->activo = 1;
            $this->save(false);
            $result = true;
        }
        return result;
    }

    public function mensajesSinLeer(){
        return $this->getRecibens()->where(['fecha_leido' => null])->count();
    }

    public function recibirMensajes(){
        foreach($this->getRecibens()->all() as $recibido){
            if(empty($recibido->fecha_recibido)){
                $recibido->mensajeRecibido();
            }
        }
    }

    public function sendCorreo($opts = [])
    {
        $opciones = array_merge([
            'asunto' => 'Mensajería Mercurio',
            'from' => Yii::$app->params['adminEmail'],
            'texto' => Html::a(
                'Pincha aquí',
                Url::toRoute([
                    'usuarios/validar', 
                    'authKey'=>Html::encode($this->getAuthKey()),
                    'id'=>$this->getId()
                ], true)
            ) . ' para completar el registro, ' . $this->nombre,
        ], $opts);
        return Yii::$app->mailer->compose()
            ->setTo($this->email)
            ->setFrom($opciones['from'])
            ->setSubject($opciones['asunto'])
            ->setHtmlBody($opciones['texto'])
            ->send();
    }

    public function beforeSave($insert){
        if (parent::beforeSave($insert)){
            if ($insert){
                $this->setPasswd();
            }
            return true;
        }else{
            return false;
        }
    }
    
    public function search($params){
        $query = Usuarios::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if (!($this->load($params) )) {
           return $dataProvider;
        }
        $query->andFilterWhere(
            [
                'id_usuario' => $this->getId(),
                'activo' => $this->activo,
            ]);
        $query->andFilterWhere(['like','email',$this->email]);
        $query->andFilterWhere(['like','rol',$this->rol]);
        $query->andFilterWhere(['like','nombre',$this->nombre]);
        return $dataProvider;
    }
}
