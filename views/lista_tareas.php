<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz con CSS</title>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <button id="createTareas">Agregar Tarea</button>
            <input type="text" placeholder="Buscar" id="load">
        </div>      
        <div class="table">
            <div class="tbl-header">
                <div class="cell">Id</div>
                <div class="cell">Nombre</div>
                <div class="cell">Fecha</div>
                <div class="cell">Action</div>
            </div>         
            <?php foreach ($datos as $key) {
                ?>
            <div class="tbl-row">
            <div class="cell" data-label="Id"><?php print $key['id'] ?></div>
            <div class="cell" data-label="Nombre"><?php print $key['task_name'] ?></div>
            <div class="cell" data-label="Fecha"><?php print $key['created_at'] ?></div>
            <div class="cell actions" data-label="Action">
                <button class="mosaico icon-lapiz updateTarea" 
                        name_row="<?php print $key['task_name']?>" 
                        id_row="<?php print $key['id'];?>"></button>
                <button class="mosaico icon-delete eliminarTarea"
                        name_row="<?php print $key['task_name']?>"  
                        id_row="<?php print $key['id'];?>"></button>
                </div>
            </div>
            <?php } ?>
            <div class="pagination"></div>      
            </div>      
    </div>
    <div class="modal" id="modal">
        <div class="modal-content">
            <h3>Elimar tarea : <label id="tarea_name"></label> ?</h3>
            <div class="buttons">
                <button class="close">Cancelar</button>
                <button class="tareaEliminar ok" id_delete="">Eliminar</button>
            </div>
        </div>
    </div>
    <div class="modal" id="modalUpdate">
        <div class="modal-content">
            <h3>Actualizar tarea</h3>
            <input type="text" id="Utarea" placeholder="Tarea">

            <div class="buttons">
                <button class="close">Cancelar</button>
                <button class="update_button ok" id_update="">Actualzar</button>
            </div>
        </div>
    </div>

    <div class="modal" id="modalCreate">
        <div class="modal-content">
            <h3>Crear tarea</h3>
            <input type="text" id="Ctarea" placeholder="Tarea">
            <div class="buttons">
                <button class="close">Cancelar</button>
                <button class="create_button ok">Crear Tarea</button>
            </div>
        </div>
    </div>
 <script src="public/js/jquery-3.7.1.js"></script>
 <script>var token = '<?php print $token;?>';</script>
 <script src="public/js/script.js"> </script>  
</body>
</html>