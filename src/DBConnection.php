<?php

namespace taskforce;

class DBConnection
{
    private $user;
    private $host;
    private $pass;
    private $db;

    /**
     * DBConnection Constructor
     * @param string $host Имя хоста или IP-Адрес
     * @param string $user Имя пользователя БД
     * @param string $pass Пароль, если не указан - null
     * @param string $db Название БД
     */
    public function __construct(string $host, string $user, string $pass, string $db) {

        $this->user = $user;
        $this->host = $host;
        $this->pass = $pass;
        $this->db = $db;
    }

    /**
     * Устанавливает и возвращает ресурс соединения
     * @return \mysqli Ресурс соединения
     */
    public function connect(){
        $link = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
        mysqli_set_charset($link, "utf8");

        return $link;
    }
}