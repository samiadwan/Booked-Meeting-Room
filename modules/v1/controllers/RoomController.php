<?php

namespace app\modules\v1\controllers;

use app\models\Room;
use yii\rest\ActiveController;

/**
 * Product controller for the `v1` module
 */
class RoomController extends ActiveController
{
   public $modelClass = Room::class;

   public function behaviors()
   {
      $behaviors = parent :: behaviors();
       $behaviors['authenticator'] = [
          'class' => \yii\filters\auth\HttpBearerAuth::class
       ];
      return $behaviors;
   }

}
