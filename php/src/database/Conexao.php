<?php

class Conexao
{

    private static $dsn = "pgsql:host=localhost;port=5432;dbname=treinamento_samuel_agenda";
    private static $user = "postgres";
    private static $password = "postgres";
    //private static $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

    private static $pdo;

    public function __construct()
    {
        //
    }

    public function __destruct()
    {
        foreach ($this as $key => $value) {
            unset($value);
        }
    }

    public static function getConexao(): PDO
    {
        if (!isset(static::$pdo)) {
            try {
                static::$pdo = new PDO(static::$dsn, static::$user, static::$password);
                //print("Conexão bem-sucedida!");
            } catch (PDOException $e) {
                die($e->getMessage());
                print "Houve um problema o conectar...";
            }
        }

        return static::$pdo;
    }
}
