<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "users".
 */
class Users extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],
            [['created_at'], 'safe'],
            [['username'], 'string', 'max' => 100],
            [['email', 'password'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['username'], 'unique'],
            [['password'], 'string', 'min' => 6], // Ensuring minimum password length
        ];
    }

    /**
     * Set attribute labels
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Before saving, hash the password if it's new or changed.
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord || $this->isAttributeChanged('password')) {
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
        }
        return parent::beforeSave($insert);
    }

    /**
     * Allow mass assignment for specific attributes
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['default'] = ['username', 'email', 'password', 'created_at'];
        return $scenarios;
    }
}
