<?php

namespace app\models;

use Yii;
use app\models\Reciben;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "mensajes".
 *
 * @property int $id_mensaje
 * @property int $id_origen
 * @property string $contenido
 * @property string $fecha
 * @property string $prioridad
 *
 * @property Usuarios $origen
 * @property Prioridades $prioridad0
 * @property Reciben[] $recibens
 * @property Usuarios[] $usuarios
 */
class Mensajes extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mensajes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_origen'], 'integer'],
            [['contenido'], 'string'],
            [['fecha'], 'safe'],
            [['prioridad'], 'string', 'max' => 127],
            [['id_origen'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['id_origen' => 'id_usuario']],
            [['prioridad'], 'exist', 'skipOnError' => true, 'targetClass' => Prioridades::className(), 'targetAttribute' => ['prioridad' => 'prioridad']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_mensaje' => 'Id Mensaje',
            'id_origen' => 'Id Origen',
            'contenido' => 'Contenido',
            'fecha' => 'Fecha',
            'prioridad' => 'Prioridad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrigen()
    {
        return $this->hasOne(Usuarios::className(), ['id_usuario' => 'id_origen']);
    }

    public function resumen($cuantos){
        $result = $this->contenido;
        if (strlen($result) > $cuantos){
            $result = substr($result, 0, $cuantos) . ' ...';
        }
        return $result;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrioridad0()
    {
        return $this->hasOne(Prioridades::className(), ['prioridad' => 'prioridad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecibens()
    {
        return $this->hasMany(Reciben::className(), ['id_mensaje' => 'id_mensaje']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(
            Usuarios::className(), 
            ['id_usuario' => 'id_usuario']
        )->viaTable(
            'reciben', 
            ['id_mensaje' => 'id_mensaje']
        );
    }

    public function enviar(Array $ids){
        foreach($ids as $usuario){
            if (Yii::$app->user->identity->id_usuario != $usuario->getId()){
                $reciben = new Reciben();
                $reciben->id_usuario = $usuario->getId();
                $reciben->id_mensaje = $this->getId();
                $reciben->save();
            }
        }
    }

    public function beforeSave($insert){
        if (parent::beforeSave($insert)){
            $this->id_origen = Yii::$app->user->identity->getId();
            $this->fecha = date('Y-m-d G:i:s');
            return true;
        }else{
            return false;
        }
    }

    public function getId(){
        return $this->id_mensaje;
    }

    public function search($params){
        $query = Mensajes::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if (!($this->load($params) && $this->validate())) {
           return $dataProvider;
        }
        $query->andFilterWhere(
            [
                'id_mensaje'=>$this->getId(),
                'origen.nombre'=>$this->origen->nombre
                
            ]);
        $query->andFilterWhere(['like','contenido',$this->contenido]);
        $query->andFilterWhere(['like','fecha',$this->fecha]);
        $query->andFilterWhere(['like','prioridad',$this->prioridad]);
        return $dataProvider;
    }

}
