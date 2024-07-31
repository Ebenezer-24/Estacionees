$(document).ready(function() {
    $('#comerciosTable').DataTable({
        ajax: {
            url: '/api/comercios',
            dataSrc: ''
        },
        columns: [
            { data: 'cuit' },
            { data: 'razon_social' },
            { data: 'direccion' },
            { data: 'estado' },
            {
                data: null,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-edit" onclick="editComercio(${data.id})">Editar</button>
                        <button class="btn btn-delete" onclick="deleteComercio(${data.id})">Eliminar</button>
                    `;
                }
            }
        ]
    });
});

function openCreateModal() {
    $('#comercioForm')[0].reset();
    $('#comercioId').val('');
    $('#modalTitle').text('Crear Comercio');
    $('#comercioModal').show();
}

function closeComercioModal() {
    $('#comercioModal').hide();
}

function saveComercio() {
    let id = $('#comercioId').val();
    let method = id ? 'PUT' : 'POST';
    let url = id ? `/api/comercios/${id}` : '/api/comercios';

    $.ajax({
        url: url,
        method: method,
        data: $('#comercioForm').serialize(),
        success: function() {
            $('#comercioModal').hide();
            $('#comerciosTable').DataTable().ajax.reload();
        },
        error: function(xhr) {
            alert('Error: ' + xhr.responseText);
        }
    });
}

function editComercio(id) {
    $.get(`/api/comercios/${id}`, function(data) {
        $('#comercioId').val(data.id);
        $('#cuit').val(data.cuit);
        $('#razon_social').val(data.razon_social);
        $('#direccion').val(data.direccion);
        $('#modalTitle').text('Editar Comercio');
        $('#comercioModal').show();
    });
}

function deleteComercio(id) {
    if (confirm('¿Está seguro de eliminar este comercio?')) {
        $.ajax({
            url: `/api/comercios/${id}`,
            method: 'DELETE',
            success: function() {
                $('#comerciosTable').DataTable().ajax.reload();
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseText);
            }
        });
    }
}
