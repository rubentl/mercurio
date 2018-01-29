<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "participan".
 *
 * @property int $id_usuario
 * @property int $id_grupo
 *
 * @property Grupos $grupo
 * @property Usuarios $usuario
 */
class Participan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'participan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_grupo'], 'required'],
            [['id_usuario', 'id_grupo'], 'integer'],
            [['id_usuario', 'id_grupo'], 'unique', 'targetAttribute' => ['id_usuario', 'id_grupo']],
            [['id_grupo'], 'exist', 'skipOnError' => true, 'targetClass' => Grupos::className(), 'targetAttribute' => ['id_grupo' => 'id_grupo']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['id_usuario' => 'id_usuario']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_usuario' => 'Id Usuario',
            'id_grupo' => 'Id Grupo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrupo()
    {
        return $this->hasOne(Grupos::className(), ['id_grupo' => 'id_grupo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id_usuario' => 'id_usuario']);
    }


}
