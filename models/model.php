<?php
require 'config/database.php'; 
class Tarea
    {        
        private $db;
        private $key;
        public function __construct()
        {
            $database = (new Database())->conectar();
            $this->db =  $database["db"];
            $this->key = $database["key_token"];
        }
        public function getKey() {
            return $this->key;
        }

        public function getAllTareas()
        {         
            $stmt = $this->db->query('CALL Tareas()');
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getTarea($id)
        {           
            $stmt = $this->db->prepare('CALL UnaTarea(:id)');
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);   
        }

        public function createTarea($nombre_tarea)
        {          
            $stmt = $this->db->prepare('CALL CreateTarea(:nombre_tarea)');
            $stmt->bindParam(':nombre_tarea', $nombre_tarea, PDO::PARAM_STR);
            return $stmt->execute();
        }

        public function updateTarea($id, $nombre_tarea)
        {          
            $stmt = $this->db->prepare("CALL UpdateTarea(:id, :nombre_tarea)");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nombre_tarea', $nombre_tarea, PDO::PARAM_STR);
            return $stmt->execute();
        }

        public function deleteTarea($id)
        {         
            $stmt = $this->db->prepare("CALL DeleteTarea(:id)");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        }
    }
?>