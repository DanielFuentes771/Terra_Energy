<?php
    require 'vendor/autoload.php';
    require 'models/model.php';
    use \Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    class TareaController 
    {
        protected $tareaModel;
        private $key;
        public function __construct()
        {
            $this->tareaModel = new Tarea();
            $this->key = $this->tareaModel->getKey();

        }
        public function view($views, $data = []) {
          extract($data);
            $viewFile = __DIR__ . '/../views/' . $views . '.php';

            if (file_exists($viewFile)) {
                require $viewFile;
            } else {
                die("<img src='../../tarea_user/public/img/404_error.png'>");
            }
        }
        public function token(){
            $payload = [
                'iss' => "http://localhost",  
                'exp' => time() + 3600,     
            ];
            return JWT::encode($payload,$this->key, 'HS256');  
        }
        public function validarToken($jwt, $key)
        {
            try {
                $decoded = JWT::decode($jwt, new Key($key, 'HS256'));               
                if (isset($decoded->exp) && $decoded->exp < time()) {
                    throw new Exception('El token ha expirado.');
                }               
                if (isset($decoded->iss) && $decoded->iss !== 'http://localhost') {
                    throw new Exception('El emisor del token no es válido.');
                }
                
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
        public function refresh(){
           return $this->tareaModel->getAllTareas(); 
        }
        public function index()
        {
            $data["datos"] = $this->tareaModel->getAllTareas();
            $data["token"] = $this->token();
            $this->view('lista_tareas', $data);
        }
        public function create()
        {
            $header = apache_request_headers(); 
            if (isset($header['Authorization'])) {
                $authorization = $header['Authorization'];               
                if (preg_match('/Bearer\s(\S+)/', $authorization, $jwt)) {              
                    if ($this->validarToken($jwt[1],$this->key)) {
                         $Tarea_name =  filter_input(INPUT_POST, 'nameTarea',FILTER_SANITIZE_STRING);
                        if ($this->tareaModel->createTarea($Tarea_name)) {
                            print json_encode([
                                    "contenedor"=>$this->refresh(),
                                    "mensaje"=>"Tarea eliminada exitosamente",
                                    "code"=>1]);
                        } 
                    } else {
                            print json_encode([
                                'mensaje' => 'Token no válido',
                                'code' => 0
                            ]);
                    }
                } 
            }
        }
        public function update($id)
        {           
            $header = apache_request_headers(); 
            if (isset($header['Authorization'])) {
                $authorization = $header['Authorization'];               
                if (preg_match('/Bearer\s(\S+)/', $authorization, $jwt)) {              
                    if ($this->validarToken($jwt[1],$this->key)) {
                          $Tarea_name =  filter_input(INPUT_POST, 'nameTarea',FILTER_SANITIZE_STRING);
                        if ($this->tareaModel->updateTarea($id, $Tarea_name)) {
                             print json_encode([
                                    "contenedor"=>$this->refresh(),
                                    "mensaje"=>"Tarea actualizada exitosamente",
                                    "code"=>1]);
                        } 
                    } else {
                        print json_encode([
                                'mensaje' => 'Token no válido',
                                'code' => 0
                            ]);
                    }
                } 
            }
        }
        public function delete($id)
        {
            $header = apache_request_headers(); 
            if (isset($header['Authorization'])) {
                $authorization = $header['Authorization'];               
                if (preg_match('/Bearer\s(\S+)/', $authorization, $jwt)) {              
                    if ($this->validarToken($jwt[1],$this->key)) {
                        if ($this->tareaModel->deleteTarea($id)) {
                            print json_encode([
                                    "contenedor"=>$this->refresh(),
                                    "mensaje"=>"Tarea eliminada exitosamente",
                                    "code"=>1]);
                        } 
                    } else {
                            print json_encode([
                                'mensaje' => 'Token no válido',
                                'code' => 0
                            ]);
                    }
                } 
            }
        }
        public function search()
        {
            $header = apache_request_headers(); 
            if (isset($header['Authorization'])) {
                $authorization = $header['Authorization'];               
                if (preg_match('/Bearer\s(\S+)/', $authorization, $jwt)) {              
                    if ($this->validarToken($jwt[1],$this->key)) {
                     $Tarea_name = filter_input(INPUT_POST, 'nameTarea',FILTER_SANITIZE_STRING);
                        print json_encode([
                            "contenedor"=>$this->tareaModel->getTarea($Tarea_name),
                            "mensaje"=>"Tarea encontrada exitosamente",
                            "code"=>1]); 
                    } else {
                            print json_encode([
                                'mensaje' => 'Token no válido',
                                'code' => 0
                            ]);
                    }
                } 
            }
        }
    }
?>