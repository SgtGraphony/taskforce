<?php

namespace app\data;

require_once(__DIR__ . '/../vendor/autoload.php');


class CSVtoSQLConverter
{

    private string $filename;
    private $fileObject;
    private $columns;

    /**
     * CSVtoSQLConverter Constructor
     * @param string $filename Путь к файлу
     */
    public function __construct(string $filename) {

        $this->filename = $filename;
        $this->fileObject = new \SplFileObject($filename);
        $this->columns = $this->fileObject->fgetcsv();
    }

    /**
     * Основной метод иморта данных, создает отдельный .sql название которого соответствует названию csv файла
     * @return void
     */
    public function import():void {

        $tableName = $this->fileObject->getBasename('.csv');
     
        $query = $this->prepareSQLQueries($this->getCSVData(), $tableName, $this->columns);
        var_dump($query);
        $this->createNewFile($tableName, $query);

        $destination = "c:/applications/ospanel/domains/taskforce/data/CSVConverted";

    }


    /**
     * Метод создает новый файл с названием таблицы и расширением .sql
     * @param string $tableName Имя таблицы
     * @param string $query Строка в виде результата метода $this->getSQLQueries
     * @return bool
     */
    private function createNewFile(string $tableName, string $query):bool {

        $newFile = fopen("$tableName.sql", 'w') or die("Unable to open File");
        $result = fwrite($newFile, $query)?? fclose($newFile);

        return $result;
    }

    /**
     * Метод проходит по строкам CSV файла и записывает их в двумерный массив
     * @return array|null Двумерный массив данных
     */
    private function getCSVData():array|null {
        $data = [];

        while(!$this->fileObject->eof()){
            $data[] = $this->fileObject->fgetcsv();
        }
        return $data;
    }

    /** Метод подготавливает SQL-INSERT выражения на добавление данных в Базу
     * @param string $tableName Имя таблицы в которую необходим импорт
     * @param array $columns Названия столбцов, по которым будет производиться INSERT
     * @param array $values CSV данные в виде двумерного массива
     * @return string|null SQL-INSERT выражения в виде строки
    */
    protected function prepareSQLQueries(array $values, string $tableName, array $columns):string {

        $columnsString = implode(", ", $columns);
        $columnsString = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $columnsString);
        
        foreach($values as $row){
            array_walk($row, function(&$value){
                $value = addslashes($value);
                $value = "'$value'";
            });
            $sql[] = "INSERT INTO $tableName ($columnsString) VALUES (" . implode(', ', $row) . ") ;";
        }
        return $sql = implode(" ", $sql);
    }

}

$obj = new CSVtoSQLConverter("../data/city.csv");

var_dump($obj->import());