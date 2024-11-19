<?php

    class Db{

    private static $conn;

        public static function getConnection(){

            if(self::$conn === null){

                self::$conn = new PDO("mysql:host=127.0.0.1;port=8889;dbname=backendshop", "root", "root");
                return self::$conn;
            }
            else {

                return self::$conn;
            }
        }
    };