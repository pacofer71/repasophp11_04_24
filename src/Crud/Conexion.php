<?php

namespace Src\Crud;

use \PDO;
use \PDOException;

class Conexion
{
    protected static ?PDO $conexion = null; //?PDO 

    public static function getConexion()
    {
        if (self::$conexion == null) self::setConexion();
        return self::$conexion;
    }

    public static function setConexion()
    {
        //Cargamos los datos del .env
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
        $dotenv->load();
        $host = $_ENV['HOST'];
        $user = $_ENV['USER'];
        $pass = $_ENV['PASSWORD'];
        $db = $_ENV['DATABASE'];

        //Nos creamos el dsn
        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
        $opciones = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

        try {
            self::$conexion = new PDO($dsn, $user, $pass, $opciones);
        } catch (PDOException $ex) {
            throw new \Exception("Error en conexion:". $ex->getMessage());
        }
    }
}
