<?php
use app\fixtures\BasicFixture;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/templates/Users.php';

class UsersFixtures extends BasicFixture
{

}

$obj = new UsersFixtures($data, $tableName);
var_dump($obj->prepareSQL());
