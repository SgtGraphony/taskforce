<?php

namespace app\fixtures\templates;

require_once __DIR__ . '/../../vendor/autoload.php';

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

$faker = new \Faker\Factory;
$faker = $faker::create('ru_RU');

$tableName = 'users';

$data = [
    'registration_date' => date_format(date_create("now"), "Y-m-d"),
    'name' => $faker->firstNameMale(),
    'password' => $faker->password(8, 15),
    'email' => $faker->email(),
    'picture' => $faker->imageUrl(),
    'phone_number' => random_int(1, 999),
    'telegram' => $faker->text(),
    'about' => $faker->realText(),
    'city_ID' => $faker->numberBetween(0, 900)
];
