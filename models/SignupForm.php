<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],
            ['username', 'string', 'max' => 100],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'This email is already taken.'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'This username is already taken.'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->password = Yii::$app->security->generatePasswordHash($this->password);
        $user->auth_key = Yii::$app->security->generateRandomString();
        
        return $user->save() ? $user : null;
    }
}
