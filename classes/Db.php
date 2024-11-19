<?php

    class Db{

    private static $conn;

        public static function getConnection(){

            include_once(__DIR__.'/../settings/settings.php');

            if(self::$conn === null){

                self::$conn = new PDO("mysql:host=" . SETTINGS["db"]["host"] . ";port=" . SETTINGS["db"]["port"] . ";dbname=" . SETTINGS["db"]["dbname"] , SETTINGS["db"]["user"] , SETTINGS["db"]["password"]);
                // $conn = new PDO("mysql:host=127.0.0.1;port=8889;dbname=backendshop", "root", "root");
                return self::$conn;
            }
            else {

                return self::$conn;
            }
        }
    };