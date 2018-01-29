<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prioridades".
 *
 * @property string $prioridad
 *
 * @property Mensajes[] $mensajes
 */
class Prioridades extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prioridades';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prioridad'], 'required'],
            [['prioridad'], 'string', 'max' => 127],
            [['prioridad'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'prioridad' => 'Prioridad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMensajes()
    {
        return $this->hasMany(Mensajes::className(), ['prioridad' => 'prioridad']);
    }


}
