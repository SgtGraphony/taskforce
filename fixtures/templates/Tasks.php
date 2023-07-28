<?php

require_once __DIR__ . '/../../vendor/autoload.php';
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
$faker = new \Faker\Factory;
$faker = $faker::create('ru_RU');

$tableName = 'task';

$data = [
    'publication_dt' => date_format(date_create("now"), "Y-m-d H:i:s"),
    'title' => $faker->text(10),
    'description' => $faker->text(30),
    'category_id' => $faker->randomDigit(),
    'performer_id' => 1,
    'budget' => random_int(999, 19999),
    'status_id' => random_int(1, 5),
    'city_id' => random_int(1, 1087),
    'client_id' => random_int(1, 6)
];
