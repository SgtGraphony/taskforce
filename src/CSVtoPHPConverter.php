<?php

namespace taskforce;

use RuntimeException;
use SplFileObject;
use taskforce\exceptions\FileFormatException;
use taskforce\exceptions\FileSourceException;

require_once("c:/applications/ospanel/domains/taskforce/vendor/autoload.php");

class CSVtoPHPConverter
{
    private string $filename;
    private array $headers;
    private array $columns;
    private array $result = [];
    private object $fileObject;
    private $error = null;

    /**
     * Converter Constructor импортирует данные из CSV файла в PHP-готовый формат в виде массива
     * @param string $filename Имя исходного файла
     * @param array $columns Массив с именами столбцов
     */
    public function __construct(string $filename, array $columns) {

        $this->filename = $filename;
        $this->fileObject = new SplFileObject($filename, 'r');
        $this->headers = $this->getCSVHeaders();
        $this->columns = $columns;
    }

    private function import(): void {

        if(!$this->validateColumns($this->columns)) {
            throw new FileFormatException("Заданы неверные столбцы заголовков!");
        }

        if($this->columns !== $this->headers) {
            throw new FileFormatException("Файл не содержит указанных столбцов!");
        }  

        if(!file_exists($this->filename)) {
            throw new FileSourceException("Указанный файл не найден!");
        }

        try {
            $this->fileObject = new SplFileObject($this->filename);
        }

        catch(RuntimeException $exception){
            throw new FileSourceException("Не удалось открыть файл на чтение!");
        }

        $this->fileObject->seek(1);
        foreach($this->getNextLine() as $line) {
            $this->result[] = $line;
        }

    }

    /**
     * Возвращает первую строку - строку с заголовками из CSV файла
     * @return array|bool Массив с заголовками
     */
    public function getCSVHeaders(): array|bool {
        $this->fileObject->rewind();

        $headers = $this->fileObject->fgetcsv();
        
        return $headers;

    }

    /**
     * Возвращает ассоциативный PHP массив, собранный из CSV данных
     * @return array|null
     */
    public function getCSVData(): array|null {
        $this->import();
        return $this->result;
    }

    /**
     * Возвращает каждую следующую строку вплоть до конца файла
     * @return ?iterable
     */
    private function getNextLine():?iterable {
        $result = null;

        while(!$this->fileObject->eof()) {
            yield $this->fileObject->fgetcsv();
        }
        return $result;
    }

    /**
     * Проверяет указанные пользователем данные из массива $columns на соответствие типу данных string
     * @return bool
     */
    private function validateColumns(array $columns): bool {
        $result = true;

        if(count($columns)) {
            foreach($columns as $column) {
                if(!is_string($column)) {
                    return $result = false;
                }
            }
        } else {
            return $result = false;
        }

        return $result;
    }

}

$spl_obj = new SplFileObject("../data/cities.csv");

$columns = $spl_obj->fgetcsv();

$obj = new CSVtoPHPConverter("../data/cities.csv", $columns);

var_dump($obj->getCSVData());
