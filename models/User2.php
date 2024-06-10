<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user2".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string|null $access_token
 * @property string|null $verification_token
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class User2 extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user2';
    }

    /**
     * {@inheritdoc}
     */

     public function behaviors()
    {
        return [
             TimestampBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],

            // [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            // [['status', 'created_at', 'updated_at'], 'integer'],
            // [['username', 'access_token', 'verification_token', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            // [['auth_key'], 'string', 'max' => 32],
            // [['username'], 'unique'],
            // [['email'], 'unique'],
            // [['access_token'], 'unique'],
            // [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    // public function attributeLabels()
    // {
    //     return [
    //         'id' => 'ID',
    //         'username' => 'Username',
    //         'auth_key' => 'Auth Key',
    //         'access_token' => 'Access Token',
    //         'verification_token' => 'Verification Token',
    //         'password_hash' => 'Password Hash',
    //         'password_reset_token' => 'Password Reset Token',
    //         'email' => 'Email',
    //         'status' => 'Status',
    //         'created_at' => 'Created At',
    //         'updated_at' => 'Updated At',
    //     ];
    // }
    /* Finds user by verification email token
    *
    * @param string $token verify email token
    * @return static|null
    */
   public static function findByVerificationToken($token) {
       return static::findOne([
           'verification_token' => $token,
           'status' => self::STATUS_INACTIVE
       ]);
   }
    /**
    * Finds user by password reset token
    *
    * @param string $token password reset token
    * @return static|null
    */
   public static function findByPasswordResetToken($token)
   {
       if (!static::isPasswordResetTokenValid($token)) {
           return null;
       }
       
       return static::findOne([
           'password_reset_token' => $token,
           'status' => self::STATUS_ACTIVE,
       ]);
   }

       /**
    * Finds out if password reset token is valid
    *
    * @param string $token password reset token
    * @return bool
    */
   public static function isPasswordResetTokenValid($token)
   {
       if (empty($token)) {
           return false;
       }

       $timestamp = (int) substr($token, strrpos($token, '_') + 1);
       $expire = Yii::$app->params['user2.passwordResetTokenExpire'];
       return $timestamp + $expire >= time();
   }

   public static function findIdentity($id)
   {
       return static::findOne($id);
   }

   public static function findIdentityByAccessToken($token, $type = null)
   {
       return static::findOne(['auth_key' => $token]);
   }

    /**
    * Finds user by username
    *
    * @param string $username
    * @return static|null
    */
   public static function findByUsername($username)
   {
       return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
   }
   public function getId()
   {
       return $this->id;
   }

   public function getAuthKey()
   {
       return $this->auth_key;
   }

   public function validateAuthKey($authKey)
   {
       return $this->auth_key === $authKey;
   }

     /**
    * Validates password
    *
    * @param string $password password to validate
    * @return bool if password provided is valid for current user
    */
   public function validatePassword($password)
   {
       return Yii::$app->security->validatePassword($password, $this->password_hash);
   }

   /**
    * Generates password hash from password and sets it to the model
    *
    * @param string $password
    */
   public function setPassword($password)
   {
       $this->password_hash = Yii::$app->security->generatePasswordHash($password);
   }

   /**
    * Generates "remember me" authentication key
    */
   public function generateAuthKey()
   {
       $this->auth_key = Yii::$app->security->generateRandomString();
   }

    /**
    * Generates new password reset token
    */
   public function generatePasswordResetToken()
   {
       $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
   }

   
   /**
    * Generates new token for email verification
    */
   public function generateEmailVerificationToken()
   {
       $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
   }

   /**
    * Removes password reset token
    */
   public function removePasswordResetToken()
   {
       $this->password_reset_token = null;
   }
    /**
     * Generates new access token
     */
    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString();
    }

    /**
     * Removes access token
     */
    public function removeAccessToken()
    {
        $this->access_token = null;
    }

}
