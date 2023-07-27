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
       $models = $tasks->findAll(['STATUS_ID' => 1]);

       $categories = Categories::find()->all();

        return $this->render('index', [
            'models' => $models,
            'categories' => $categories,
            'tasks' => $tasks
            
        ]);
    }
}