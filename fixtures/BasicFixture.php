<?php

namespace app\fixtures;

require_once __DIR__ . '/../vendor/autoload.php';

abstract class BasicFixture
{
 
    protected array $data;
    protected string $values;
    protected string $tableName;
    protected string $columnsString;
    protected array $columnsArray = [];
    /**
     * UsersFixtures constructor
     * @param array $data Массив со значениями ['Поле'] => Необходимый генератор данных
     * @param string $tableName Название таблицы в БД
     */
    public function __construct(array $data, string $tableName) {
        $this->data = $data;
        $this->tableName = $tableName;

        foreach($data as $key=>$value) {
            $this->columnsArray[] = $key;
        }
    }

    protected function prepareValues() {
        $values = implode("', '", $this->data);
        $this->values = str_replace($values,"'$values'", $values);

        $columns = implode("`, `", $this->columnsArray);
        $this->columnsString = str_replace($columns,"`$columns`", $columns);
    }

    protected function createFaker() {
        $faker = new \Faker\Factory;
        $faker = $faker::create('ru_RU');

        return $faker;
    }

    public function prepareSQL() {
        $mysqli = new \mysqli("localhost", "root", "", "taskforce");

        $this->prepareValues();

        $SQL = "INSERT INTO
        `taskforce`.`$this->tableName`
        ($this->columnsString)
        VALUES
        ($this->values)";

        $mysqli->query($SQL)? print "Генерация выполнена успешно" : print "Ошибка в выполнении скрипта";

    }
}
