$(document).ready(function() {
    // Inicializar DataTable
    var table = $('#recargasTable').DataTable({
        ajax: {
            url: '/api/recargas',
            dataSrc: ''
        },
        columns: [
            { data: 'numero_comercio', title: 'ID Comercio' },
            { data: 'dni', title: 'DNI Usuario' },
            { data: 'patente', title: 'Patente' },
            { data: 'importe', title: 'Importe' },
            { data: 'created_at', title: 'Fecha' },
            { data: null, title: 'Acciones', render: function (data, type, row) {
                return `
                    <button onclick="verRecarga(${row.id})">Ver</button>
                   
                `;
            }}
        ]
    });

    // Función para abrir el modal de creación de recarga
    $('#createRecargaButton').click(function() {
        openRecargaModal();
    });

    // Función para guardar la recarga
    $('#guardarRecarga').click(function() {
        let id = $('#recargaId').val();
        let comercio_id = $('#comercioId').val();
        let dni = $('#dniUsuario').val();
        let patente = $('#patente').val();
        let importe = $('#importe').val();

        let url = '/api/recargas';
        let method = 'POST';

        if (id) {
            url = `/api/recargas/${id}`;
            method = 'PUT';
        }

        $.ajax({
            url: url,
            method: method,
            contentType: 'application/json',
            data: JSON.stringify({
                comercio_id: comercio_id,
                dni: dni,
                patente: patente,
                importe: importe
            }),
            success: function(response) {
                alert('Recarga realizada con éxito.');
                closeRecargaModal();
                table.ajax.reload();
            },
            error: function(response) {
                if (response.status === 403) {
                    alert('El comercio no está autorizado para realizar recargas.');
                } else {
                    alert('Error al realizar la recarga. Por favor, intente nuevamente.');
                }
            }
        });
    });

    // Función para cancelar la operación de recarga
    $('#cancelarRecarga').click(function() {
        closeRecargaModal();
    });

    // Cerrar el modal de recarga
    function closeRecargaModal() {
        $('#recargaModal').hide();
        $('#recargaForm').trigger("reset");
    }
    
    // Abrir el modal de recarga
    function openRecargaModal() {
        $('#recargaModal').show();
    }
});

function verRecarga(id) {
    $.get(`/api/recargas/${id}`, function(data) {
        alert(`Detalles de la Recarga:\n\nComercio: ${data.comercio_id}\nDNI: ${data.dni}\nPatente: ${data.patente}\nImporte: ${data.importe}`);
    });
}

function eliminarRecarga(id) {
    if (confirm('¿Estás seguro de que deseas eliminar esta recarga?')) {
        $.ajax({
            url: `/api/recargas/${id}`,
            method: 'DELETE',
            success: function() {
                alert('Recarga eliminada.');
                $('#recargasTable').DataTable().ajax.reload();
            },
            error: function() {
                alert('Error al eliminar la recarga. Por favor, intente nuevamente.');
            }
        });
    }
}
