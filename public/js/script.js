 function paginate(){
    const rows = 10; 
    $('.pagination').empty();
    const tbl_row = $('.table').find('.tbl-row');
    const totalPages = Math.ceil(tbl_row.length / rows);
    for (let i = 1; i <= totalPages; i++) {
        const button = $('<button>').text(i);
        button.on('click',function(){
            $(this).addClass('pagina').siblings().removeClass('pagina');
            paginar(i);
         });
    $('.pagination').append(button);
    }
    function paginar(page) {
            const inicio = (page - 1) * rows;
            const fin = inicio + rows;
            tbl_row.each(function(index) {
                $(this).toggle(index >= inicio && index < fin);
            });
        }
        paginar(1); 
    }
$(function() {
    paginate();
    $(document).on('click', '.tbl-row', function() {
        $('.cell').removeClass('selected');
        $(this).find(".cell").addClass('selected');
    });
    $(document).on('click', '.eliminarTarea', function() {
        $('#tarea_name').html($(this).attr('name_row'));
        $('.tareaEliminar').attr("id_delete", $(this).attr('id_row'));
        $('#modal').css('display', 'flex');
    });
    $(document).on('keyup', '#load', function(){
    var busqueda = $(this).val();
    if( busqueda.length>3 || busqueda==''){
        $.ajax({
        url: 'search/',
        type: 'POST',
        data: { nameTarea: $(this).val() },
            beforeSend: function(xhr) {
            xhr.setRequestHeader('Authorization', 'Bearer '+token);
        },
        success: function(response){
            var json = JSON.parse(response);
            if (json.code == 1) {
                var innerrHTML = '';
                if(json.contenedor.length>0){
                json.contenedor.forEach(tarea => {
                    innerrHTML += '<div class="tbl-row">' +
                        '<div class="cell" data-label="Id">' + tarea.id + '</div>' +
                        '<div class="cell" data-label="Nombre">' + tarea.task_name + '</div>' +
                        '<div class="cell" data-label="Fecha">' + tarea.created_at + '</div>' +
                        '<div class="cell actions" data-label="Action">' +
                        '<button class="mosaico icon-lapiz updateTarea" name_row="' + tarea.task_name + '" id_row="' + tarea.id + '"></button>' +
                        '<button class="mosaico icon-delete eliminarTarea" name_row="' + tarea.task_name + '" id_row="' + tarea.id + '"></button>' +
                        '</div>' +
                        '</div>';
                });
            }else{
                innerrHTML += '<div class="tbl-row"> No se encontraron registros</div>';
            }
            $('.tbl-row').remove();
            $('.tbl-header').after(innerrHTML);
             paginate();
            }
        },
        error: function(xhr, status, error) {
            console.error('Error :', error);
        }
    });
}
});
$(document).on('click', '.updateTarea', function() {
    $("#Utarea").val($(this).attr('name_row'));
    $('.update_button').attr("id_update", $(this).attr('id_row'));
    $('#modalUpdate').css('display', 'flex');
});

$(document).on('click', '.tareaEliminar', function() {
$.ajax({
    url: 'delete/' + $(this).attr("id_delete"),
    type: 'POST',
    beforeSend: function(xhr) {
        xhr.setRequestHeader('Authorization', 'Bearer '+token);
    },
    success: function(response) {
         var json = JSON.parse(response);
        if (json.code == 1) {
            var innerrHTML = '';
            json.contenedor.forEach(tarea => {
                innerrHTML += '<div class="tbl-row">' +
                    '<div class="cell" data-label="Id">' + tarea.id + '</div>' +
                    '<div class="cell" data-label="Nombre">' + tarea.task_name + '</div>' +
                    '<div class="cell" data-label="Fecha">' + tarea.created_at + '</div>' +
                    '<div class="cell actions" data-label="Action">' +
                    '<button class="mosaico icon-lapiz updateTarea" name_row="' + tarea.task_name + '" id_row="' + tarea.id + '"></button>' +
                    '<button class="mosaico icon-delete eliminarTarea" name_row="' + tarea.task_name + '" id_row="' + tarea.id + '"></button>' +
                    '</div>' +
                    '</div>';
            });
            $('.tbl-row').remove();
            $('.tbl-header').after(innerrHTML);
            $('.modal').css('display', 'none');
            paginate();
        } else {
            alert(JSON.parse(response).mensaje);
        }
    },
    error: function(xhr, status, error) {
        console.error('Error :', error);
    }
});
});
 $(document).on('keydown', function(event) {
     if (event.key === "Enter") {
        $('.modal .ok:visible').click();
    }
 });
$(document).on('click', '.update_button', function() {
$.ajax({
    url: 'update/' + $(this).attr("id_update"),
    type: 'POST',
    data: { nameTarea: $('#Utarea').val() },
    beforeSend: function(xhr) {
        xhr.setRequestHeader('Authorization', 'Bearer '+token);
    },
    success: function(response) {
        var json = JSON.parse(response);
        if (json.code == 1) {
            var innerrHTML = '';
            json.contenedor.forEach(tarea => {
                innerrHTML += '<div class="tbl-row">' +
                    '<div class="cell" data-label="Id">' + tarea.id + '</div>' +
                    '<div class="cell" data-label="Nombre">' + tarea.task_name + '</div>' +
                    '<div class="cell" data-label="Fecha">' + tarea.created_at + '</div>' +
                    '<div class="cell actions" data-label="Action">' +
                    '<button class="mosaico icon-lapiz updateTarea" name_row="' + tarea.task_name + '" id_row="' + tarea.id + '"></button>' +
                    '<button class="mosaico icon-delete eliminarTarea" name_row="' + tarea.task_name + '" id_row="' + tarea.id + '"></button>' +
                    '</div>' +
                    '</div>';
            });
            $('.tbl-row').remove();
            $('.tbl-header').after(innerrHTML);
            $('.modal').css('display', 'none');
            paginate();
        } else {
            alert(JSON.parse(response).mensaje);
        }
    },
    error: function(xhr, status, error) {
        console.error('Error :', error);
    }
});
});
$("#createTareas").click(function() {
    $('#modalCreate').css('display', 'flex');
});

$(".create_button").click(function() {
    $.ajax({
        url: 'create/',
        type: 'POST',
        data: { nameTarea: $('#Ctarea').val() },
        beforeSend: function(xhr) {
            xhr.setRequestHeader('Authorization', 'Bearer '+token);
        },
        success: function(response) {

            var json = JSON.parse(response);
            if (json.code == 1) {
            var innerrHTML = '';
                json.contenedor.forEach(tarea => {
                    innerrHTML += '<div class="tbl-row">' +
                        '<div class="cell" data-label="Id">' + tarea.id + '</div>' +
                        '<div class="cell" data-label="Nombre">' + tarea.task_name + '</div>' +
                        '<div class="cell" data-label="Fecha">' + tarea.created_at + '</div>' +
                        '<div class="cell actions" data-label="Action">' +
                        '<button class="mosaico icon-lapiz updateTarea" name_row="' + tarea.task_name + '" id_row="' + tarea.id + '"></button>' +
                        '<button class="mosaico icon-delete eliminarTarea" name_row="' + tarea.task_name + '" id_row="' + tarea.id + '"></button>' +
                        '</div>' +
                        '</div>';
                });
                $('.tbl-row').remove();
                $('.tbl-header').after(innerrHTML);
                $('.modal').css('display', 'none');
                paginate();
            } else {
                alert(JSON.parse(response).mensaje);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
});

$(".close").click(function() {
    $('.modal').css('display', 'none');
});
$(document).on('keydown', function(event) {
    if (event.key === "Escape") {
        $('.modal').css('display', 'none');
    }
});
});