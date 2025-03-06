<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

class ResetPasswordForm extends Model
{
    public $password;
    private $_user;

    public function __construct($token, $config = [])
    {
        $this->_user = User::findOne(['password_reset_token' => $token]);

        if (!$this->_user) {
            throw new \yii\web\BadRequestHttpException('Invalid token.');
        }

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function resetPassword()
    {
        $user = $this->_user;
        $user->password = Yii::$app->security->generatePasswordHash($this->password);
        $user->password_reset_token = null;

        return $user->save(false);
    }
}
