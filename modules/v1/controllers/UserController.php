<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use app\models\User;
use Yii;

class UserController extends ActiveController
{
    // public $modelClass = 'app\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        return $behaviors;
    }

    public function actionLogin()
    {
        $request = Yii::$app->request;
        $username = $request->post('username');
        $password = $request->post('password');

        $user = User::findByUsername($username);
        if ($user && $user->validatePassword($password)) {
            // Generate a new access token
            $user->generateAuthKey();
            if ($user->save(false)) {
                return ['token' => $user->auth_key];
            } else {
                Yii::$app->response->statusCode = 500;
                return ['message' => 'Failed to save user token'];
            }
        } else {
            Yii::$app->response->statusCode = 401;
            return ['message' => 'Invalid username or password'];
        }
    }

    // public function actionLogout()
    // {
    //     $user = Yii::$app->user->identity;
    //     if ($user) {
    //         // Directly set auth_key to null
    //         $user->auth_key = null;
    //         if ($user->save(false)) {
    //             return ['message' => 'Logged out successfully'];
    //         } else {
    //             Yii::$app->response->statusCode = 500;
    //             return ['message' => 'Failed to log out'];
    //         }
    //     } else {
    //         Yii::$app->response->statusCode = 401;
    //         return ['message' => 'No user is currently logged in'];
    //     }
    // }
}
