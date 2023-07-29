<?php

namespace app\controllers;

use app\models\Category;
use app\models\Reply;
use app\models\Task;
use yii\data\Pagination;
use yii\web\Controller;
use Yii;

require_once __DIR__ . '/../vendor/autoload.php';

class TasksController extends Controller
{

    public function actionIndex()
    {
       $tasks = new Task();
       $tasks->load(Yii::$app->request->post());

       $tasksQuery = $tasks->getSearchQuery()->with('category', 'city');
       $categories = Category::find()->all();

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
        $model = Task::find()->where(['ID' => (yii::$app->request->get())])->one();
        $replies = $model->getReply()->orderBy('publication_dt DESC')->all(); 



        return $this->render('view', [
            'model' => $model,
            'replies' => $replies
        ]);
    }
}