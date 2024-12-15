<?php
    class Database
    {
        private $hostname;
        private $database;
        private $username;
        private $password;
        private $charset;
        protected $key_token;
        public function __construct()
        {
            $config = parse_ini_file('config.ini', true);
            $this->hostname = $config['database']['hostname'];
            $this->database = $config['database']['database'];
            $this->username = $config['database']['username'];
            $this->password = $config['database']['password'];
            $this->charset = $config['database']['charset'];
            $this->key_token = $config['api']['key_token'];
        }
        public function conectar()
        {
            try {
                $conexion = "mysql:host=" . $this->hostname . ";dbname=" . $this->database . ";charset=" . $this->charset;
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];

                $pdo = new PDO($conexion, $this->username, $this->password, $options);

               return [
                    'pdo' => $pdo,
                    'key_token' => $this->key_token
                ];
            } catch (PDOException $e) {
                echo 'Error de conexión: ' . $e->getMessage();
                exit;
            }
        }
    }   
?>