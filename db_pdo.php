<?php

namespace DB {
    class DB_PDO{
        private $conn;
        private static $instance = null;

        public function __construct(array $config){
            $this->conn = new \PDO(
                $config['driver'] . ":host=" . $config['host'] . ";dbname=" . $config['database'],
                $config['user'],
                $config['password']
            );
            print_r($config);
        }

        public static function getInstance(array $config){
            if (!static::$instance) {
                static::$instance = new DB_PDO($config);
            }
            return static::$instance;
        }

        public function getConnection(){
            return $this->conn;
        }
    }
}

