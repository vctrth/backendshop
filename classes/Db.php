<?php

class Db {
    private static $conn;

    public static function getConnection() {
        require __DIR__ . "/../vendor/autoload.php";

        // $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        // $dotenv->load();

        if (self::$conn === null) {

            $pathToSSL = __DIR__ . "/../DigiCertGlobalRootCA.crt.pem";
            $options = [
                PDO::MYSQL_ATTR_SSL_CA => $pathToSSL
            ];

            $host = getenv('DB_HOST');
            $port = getenv('DB_PORT');
            $dbname = getenv('DB_NAME');
            $user = getenv('DB_USER');
            $password = getenv('DB_PASSWORD');
            // $host = $_ENV['DB_HOST'];
            // $port = $_ENV['DB_PORT'];
            // $dbname = $_ENV['DB_NAME'];
            // $user = $_ENV['DB_USER'];
            // $password = $_ENV['DB_PASSWORD'];

            self::$conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $password, $options);
            // self::$conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $password);
            return self::$conn;
        } else {
            return self::$conn;
        }
    }
}