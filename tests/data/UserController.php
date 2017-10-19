<?php

namespace yii2mod\swagger\tests\data;

use yii\rest\Controller;

/**
 * Class UserController
 *
 * @package yii2mod\swagger\tests\data
 */
class UserController extends Controller
{
    /**
     * @SWG\Get(path="/user",
     *     tags={"User"},
     *     summary="Retrieves the collection of User resources.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "User collection response",
     *         @SWG\Schema(ref = "#/definitions/User")
     *     ),
     * )
     */
    public function actionIndex()
    {
    }
}
