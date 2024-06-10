<?php

namespace app\modules\v1\controllers;

use app\models\Blog;
use yii\rest\ActiveController;

/**
 * Blog controller for the `v1` module
 */
class BlogController extends ActiveController
{
   public $modelClass = Blog::class;

   public function behaviors()
   {
      $behaviors = parent :: behaviors();
      // $behaviors['authenticator'] = [
      //    'class' => \yii\filters\auth\HttpBearerAuth::class,
      // ];
      return $behaviors;
   }

}
