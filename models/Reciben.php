<?php

namespace app\models;
use yii\data\ActiveDataProvider;

use Yii;

/**
 * This is the model class for table "reciben".
 *
 * @property int $id_usuario
 * @property int $id_mensaje
 * @property string $fecha_recibido
 * @property string $fecha_leido
 *
 * @property Usuarios $usuario
 * @property Mensajes $mensaje
 */
class Reciben extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reciben';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_mensaje'], 'required'],
            [['id_usuario', 'id_mensaje'], 'integer'],
            [['fecha_recibido', 'fecha_leido'], 'safe'],
            [['id_usuario', 'id_mensaje'], 'unique', 'targetAttribute' => ['id_usuario', 'id_mensaje']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['id_usuario' => 'id_usuario']],
            [['id_mensaje'], 'exist', 'skipOnError' => true, 'targetClass' => Mensajes::className(), 'targetAttribute' => ['id_mensaje' => 'id_mensaje']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_usuario' => 'Id Usuario',
            'id_mensaje' => 'Id Mensaje',
            'fecha_recibido' => 'Fecha Recibido',
            'fecha_leido' => 'Fecha Leido',
        ];
    }

    public function mensajeLeido(){
        if (empty($this->fecha_leido)){
            $this->fecha_leido = date('Y-m-d G:i:s');
            $this->save(false);
        }
    }

    public function mensajeRecibido(){
        if (empty($this->fecha_recibido)){
            $this->fecha_recibido = date('Y-m-d G:i:s');
            $this->save(false);
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id_usuario' => 'id_usuario']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMensaje()
    {
        return $this->hasOne(Mensajes::className(), ['id_mensaje' => 'id_mensaje']);
    }

}
