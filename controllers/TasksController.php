<?php

namespace app\controllers;

use app\models\Categories;
use app\models\Tasks;
use yii\data\Pagination;
use yii\web\Controller;
use Yii;

require_once __DIR__ . '/../vendor/autoload.php';

class TasksController extends Controller
{

    public function actionIndex()
    {
       $tasks = new Tasks;
       $tasks->load(Yii::$app->request->post());

       $tasksQuery = $tasks->getSearchQuery();
       $categories = Categories::find()->all();

       $countQuery = clone $tasksQuery;
       $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 5,'forcePageParam' => false, 'pageSizeParam' => false]);
       $models = $tasksQuery->offset($pages->offset)->limit($pages->limit)->all();
       

       

        return $this->render('index', [
            'models' => $models,
            'categories' => $categories,
            'tasks' => $tasks,
            'pages' => $pages
            
        ]);
    }

    public function actionView()
    {
        $tasks = new Tasks;
        $tasks->load(Yii::$app->request->get());
    }
}