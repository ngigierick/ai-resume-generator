<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

class PasswordResetRequestForm extends Model
{
    public $email;

    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist', 'targetClass' => User::class, 'message' => 'No user found with this email.'],
        ];
    }

    public function sendEmail()
    {
        $user = User::findOne(['email' => $this->email]);

        if (!$user) {
            return false;
        }

        $user->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
        if (!$user->save()) {
            return false;
        }

        return Yii::$app->mailer->compose()
            ->setTo($this->email)
            ->setFrom([Yii::$app->params['adminEmail'] => 'Admin'])
            ->setSubject('Password reset request')
            ->setTextBody("Click this link to reset your password: " . Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]))
            ->send();
    }
}
