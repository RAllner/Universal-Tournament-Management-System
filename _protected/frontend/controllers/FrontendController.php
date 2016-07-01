<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

/**
 * FrontendController extends Controller and implements the behaviors() method
 * where you can specify the access control ( AC filter + RBAC) for
 * your controllers and their actions.
 */
class FrontendController extends Controller
{
    /**
     * Returns a list of behaviors that this component should behave as.
     * Here we use RBAC in combination with AccessControl filter.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'controllers' => ['article'],
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'admin', 'home'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'controllers' => ['article'],
                        'actions' => ['create', 'update', 'admin', 'home'],
                        'allow' => true,
                        'roles' => ['editor'],
                    ],
                    [
                        'controllers' => ['article'],
                        'actions' => ['index', 'view', 'home'],
                        'allow' => true,
                    ],
                    [
                        'controllers' => ['galleries'],
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'admin'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'controllers' => ['galleries'],
                        'actions' => ['create', 'update', 'admin'],
                        'allow' => true,
                        'roles' => ['editor'],
                    ],
                    [
                        'controllers' => ['galleries'],
                        'actions' => ['index', 'view'],
                        'allow' => true,
                    ],
                    [
                        'controllers' => ['videos'],
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'admin'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'controllers' => ['videos'],
                        'actions' => ['create', 'update', 'admin'],
                        'allow' => true,
                        'roles' => ['editor'],
                    ],
                    [
                        'controllers' => ['videos'],
                        'actions' => ['index', 'view'],
                        'allow' => true,
                    ],
                    [
                        'controllers' => ['player'],
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'admin'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'controllers' => ['player'],
                        'actions' => ['create', 'update'],
                        'allow' => true,
                        'roles' => ['editor'],
                    ],
                    [
                        'controllers' => ['player'],
                        'actions' => ['create', 'update'],
                        'allow' => true,
                        'roles' => ['member'],
                    ],
                    [
                        'controllers' => ['player'],
                        'actions' => ['index', 'view'],
                        'allow' => true,
                    ],
                    [
                        'controllers' => ['halloffame'],
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'admin'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'controllers' => ['halloffame'],
                        'actions' => ['create', 'update', 'admin'],
                        'allow' => true,
                        'roles' => ['editor'],
                    ],
                    [
                        'controllers' => ['halloffame'],
                        'actions' => ['index', 'view'],
                        'allow' => true,
                    ],
                    [
                        'controllers' => ['organisation'],
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'admin'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'controllers' => ['organisation'],
                        'actions' => ['create', 'update', 'admin'],
                        'allow' => true,
                        'roles' => ['editor'],
                    ],
                    [
                        'controllers' => ['organisation'],
                        'actions' => ['index', 'view'],
                        'allow' => true,
                    ],
                    [
                        'controllers' => ['locations'],
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'admin', 'home'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'controllers' => ['locations'],
                        'actions' => ['create', 'update', 'admin', 'home'],
                        'allow' => true,
                        'roles' => ['editor'],
                    ],
                    [
                        'controllers' => ['locations'],
                        'actions' => ['index', 'view', 'home'],
                        'allow' => true,
                    ],
                    [
                        'controllers' => ['events'],
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'admin', 'home'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'controllers' => ['events'],
                        'actions' => ['create', 'update', 'admin', 'home'],
                        'allow' => true,
                        'roles' => ['editor'],
                    ],
                    [
                        'controllers' => ['events'],
                        'actions' => ['index', 'view', 'home'],
                        'allow' => true,
                    ],
                ], // rules

            ], // access

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ], // verbs

        ]; // return

    } // behaviors

} // AppController
