<?php
use app\fixtures\BasicFixture;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/templates/Tasks.php';

class TasksFixture extends BasicFixture
{

}

$obj = new TasksFixture($data, $tableName);
var_dump($obj->prepareSQL());