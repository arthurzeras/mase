<?php

class BD{
    private static $instance;
    private static $bd = "senhas";
    private static $host = "localhost";
    private static $user = "arthurzeras";
    private static $pass = "";

    public static function getInstance(){
        if(!isset(self::$instance)){
            try{
                self::$instance = new PDO('mysql:host='.self::$host.';dbname='.self::$bd,self::$user,self::$pass);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            }catch (PDOException $e){
                echo $e->getMessage();
            }
        }
        return self::$instance;
    }

    public static function prepare($sql){
        return self::getInstance()->prepare($sql);
    }
}