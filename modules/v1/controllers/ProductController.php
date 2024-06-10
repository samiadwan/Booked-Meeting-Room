<?php

namespace app\modules\v1\controllers;

use app\models\Product;
use yii\rest\ActiveController;

/**
 * Product controller for the `v1` module
 */
class ProductController extends ActiveController
{
   public $modelClass = Product::class;

   public function behaviors()
   {
      $behaviors = parent :: behaviors();
       $behaviors['authenticator'] = [
          'class' => \yii\filters\auth\HttpBearerAuth::class
       ];
      return $behaviors;
   }

}
