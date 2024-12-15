<?php
require 'controller/TareaController.php';
$folder = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$vista = !empty($folder[1]) ? $folder[1] : 'index';
$parametros = !empty($folder[2]) ? $folder[2] : null;

if (class_exists('TareaController') && method_exists('TareaController', $vista)) {
    $controller = new TareaController;
    if ($parametros !== null) {
        $controller->$vista($parametros);
    } else {
        $controller->$vista();
    }
} else {
    echo "<img src='public/img/404_error.png' style='width:95%'>";
}
?>