<?php
    class Database
    {
        private $config;
        protected $api;
        public function __construct()
        {
            $read = parse_ini_file('config.ini', true);
            $this->config = $read['database'];           
            $this->api = $read['api']['key_token'];
        }
        public function conectar()
        {
            try {              
                $db = new PDO("mysql:host=".$this->config["hostname"].";dbname=".$this->config["database"].";",
                                $this->config["username"], $this->config["password"],
                                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
               return [
                    'db' => $db,
                    'key_token' => $this->api
                ];
            } catch (PDOException $e) {
                echo 'Error de conexión: ' . $e->getMessage();
                exit;
            }
        }
    }   
?>