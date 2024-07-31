$(document).ready(function() {
    $('#estacionamientosTable').DataTable({
        ajax: {
            url: '/api/estacionamientos',
            dataSrc: ''
        },
        columns: [
            { data: 'numero_espacio' },
            { data: 'patente' },
            { data: 'hora_inicio' },
            { data: 'hora_fin' },
            { data: 'estado' },
            {
                data: null,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-edit" onclick="editEstacionamiento(${data.id})">Editar</button>
                        <button class="btn btn-delete" onclick="deleteEstacionamiento(${data.id})">Eliminar</button>
                    `;
                }
            }
        ]
    });
});

function openCreateModal() {
    $('#modal-title').text('Crear Nuevo Estacionamiento');
    $('#modal-form')[0].reset();
    $('#modal').show();
}

function editEstacionamiento(id) {
    $.ajax({
        url: `/api/estacionamientos/${id}`,
        method: 'GET',
        success: function(data) {
            $('#modal-id').val(data.id);
            $('#modal-espacio').val(data.numero_espacio);
            $('#modal-patente').val(data.patente);
            $('#modal-inicio').val(data.hora_inicio.replace(" ", "T"));
            $('#modal-fin').val(data.hora_fin.replace(" ", "T"));
            $('#modal-title').text('Editar Estacionamiento');
            $('#modal').show();
        }
    });
}

function submitForm() {
    var id = $('#modal-id').val();
    var url = id ? `/api/estacionamientos/${id}` : '/api/estacionamientos';
    var method = id ? 'PUT' : 'POST';
    var data = {
        numero_espacio: $('#modal-espacio').val(),
        patente: $('#modal-patente').val(),
        hora_inicio: $('#modal-inicio').val(),
        hora_fin: $('#modal-fin').val(),
        estado: 'ocupado'
    };

    $.ajax({
        url: url,
        method: method,
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function() {
            $('#estacionamientosTable').DataTable().ajax.reload();
            closeModal();
        },
        error: function(xhr) {
            alert('Error al guardar el estacionamiento');
        }
    });
}

function deleteEstacionamiento(id) {
    if (confirm('¿Está seguro de eliminar este estacionamiento?')) {
        $.ajax({
            url: `/api/estacionamientos/${id}`,
            method: 'DELETE',
            success: function() {
                $('#estacionamientosTable').DataTable().ajax.reload();
            },
            error: function(xhr) {
                alert('Error al eliminar el estacionamiento');
            }
        });
    }
}

function closeModal() {
    $('#modal').hide();
}
