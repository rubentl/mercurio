<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "roles".
 *
 * @property string $rol
 *
 * @property Usuarios[] $usuarios
 */
class Roles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'roles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rol'], 'required'],
            [['rol'], 'string', 'max' => 15],
            [['rol'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rol' => 'Rol',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::className(), ['rol' => 'rol']);
    }

}
