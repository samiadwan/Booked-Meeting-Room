<?php

namespace app\modules\v1\controllers;

use app\models\Blog;
use app\models\Category2;
use yii\rest\ActiveController;

/**
 * Category controller for the `v1` module
 */
class CategoryController extends ActiveController
{
   public $modelClass = Category2::class;

   public function behaviors()
   {
      $behaviors = parent :: behaviors();
      // $behaviors['authenticator'] = [
      //    'class' => \yii\filters\auth\HttpBearerAuth::class,
      // ];
      return $behaviors;
   }

}
