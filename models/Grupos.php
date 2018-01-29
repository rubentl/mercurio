<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "grupos".
 *
 * @property int $id_grupo
 * @property string $grupo
 *
 * @property Participan[] $participans
 * @property Usuarios[] $usuarios
 */
class Grupos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grupos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['grupo'], 'string', 'max' => 127],
            [['grupo'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_grupo' => 'Id Grupo',
            'grupo' => 'Grupo',
        ];
    }

    public function getId(){
        return $this->id_grupo;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipans()
    {
        return $this->hasMany(Participan::className(), ['id_grupo' => 'id_grupo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::className(), ['id_usuario' => 'id_usuario'])->viaTable('participan', ['id_grupo' => 'id_grupo']);
    }

    public function search($params){
        $query = Grupos::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if (!($this->load($params))) {
           return $dataProvider;
        }
        $query->andFilterWhere(
            [
                'id_grupo'=>$this->getId(),
                'grupo'=>$this->grupo
            ]);
        return $dataProvider;
    }

}
