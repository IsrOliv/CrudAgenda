<?php
class Conexao
{
    private static $conexao;
    private function __construct()
    {}
    public static function getInstance()
    {
        if (is_null(self::$conexao)) {
            $localhost = "127.0.0.1"; 
            $username = "root"; 
            $password = ""; 
            $dbname = "db_agenda";             
            self::$conexao = new mysqli($localhost, $username, $password, $dbname);            
        }
        return self::$conexao;
    }
}