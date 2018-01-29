<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [
                ['name', 'email', 'subject', 'body'], 
                'required', 
                'message' => '{attribute} no puede estar vacío'
            ],
            // email has to be a valid email address
            ['email', 'email', 'message' => 'Correo electrónico no es válido'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha', 'message' => 'El código de verificación es incorrecto'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Código de verificación',
            'name' => 'Nombre',
            'email' => 'Correo electrónico',
            'subject' => 'Asunto',
            'body' => 'Mensaje',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact($destino)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($destino)
                ->setFrom([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();

            return true;
        }
        return false;
    }
}
