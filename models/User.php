<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model class for authentication.
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users'; // Ensure this matches the actual table name
    }

    /**
     * Finds an identity by the given ID.
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * Finds an identity by the given access token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['access_token' => $token]);
    }

    /**
     * Finds a user by username.
     */
    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }

    /**
     * Gets the user ID.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the authentication key.
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates authentication key.
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password using Yii security.
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Sets the password (hashing it before saving).
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates a new authentication key.
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Before saving, hash the password if it's new or changed.
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord || $this->isAttributeChanged('password')) {
            $this->setPassword($this->password);
        }
        if ($this->isNewRecord) {
            $this->generateAuthKey();
        }
        return parent::beforeSave($insert);
    }
}
