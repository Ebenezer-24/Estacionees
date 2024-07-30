$(document).ready(function() {
    $('#usuariosTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/api/usuarios",
            "type": "GET",
            "dataSrc": function(json) {
                return json.data || json;
            }
        },
        "columns": [
            { "data": "id" },
            { "data": "dni" },
            { "data": "nombre" },
            { "data": "apellido" },
            { "data": "domicilio" },
            { "data": "email" },
            { 
                "data": "fecha_nacimiento",
                "render": function(data, type, row) {
                    if (type === 'display' || type === 'filter') {
                        return data ? new Date(data).toLocaleDateString() : '';
                    }
                    return data;
                }
            },
            { "data": "patente" },
            {
                "data": null,
                "render": function (data, type, row) {
                    return `
                        <button class="btn btn-edit" onclick="editUsuario(${row.id})">Editar</button>
                        <button class="btn btn-delete" onclick="deleteUsuario(${row.id})">Eliminar</button>
                    `;
                },
                "orderable": false
            }
        ],
        "lengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]]
    });
});

function openCreateModal() {
    // Limpiar errores previos
    $('#createForm span.text-error').text('');
    // Mostrar el modal
    $('#createModal').show();
}

function closeCreateModal() {
    $('#createModal').hide();
}

function createUsuario() {
    var usuarioData = {
        dni: $('#createDni').val(),
        nombre: $('#createNombre').val(),
        apellido: $('#createApellido').val(),
        domicilio: $('#createDomicilio').val(),
        email: $('#createEmail').val(),
        fecha_nacimiento: $('#createFechaNacimiento').val(),
        patente: $('#createPatente').val(),
        contraseña: $('#createContraseña').val()
    };

    $.ajax({
        url: '/api/usuarios',
        type: 'POST',
        data: usuarioData,
        success: function(result) {
            alert("Usuario creado con éxito");
            $('#createModal').hide();
            $('#usuariosTable').DataTable().ajax.reload();
        },
        error: function(err) {
            if (err.status === 422) {
                // Manejo de errores de validación
                var errors = err.responseJSON.errors;
                if (errors.dni) {
                    $('#errorDni').text(errors.dni.join(' '));
                }
                if (errors.nombre) {
                    $('#errorNombre').text(errors.nombre.join(' '));
                }
                if (errors.apellido) {
                    $('#errorApellido').text(errors.apellido.join(' '));
                }
                if (errors.domicilio) {
                    $('#errorDomicilio').text(errors.domicilio.join(' '));
                }
                if (errors.email) {
                    $('#errorEmail').text(errors.email.join(' '));
                }
                if (errors.fecha_nacimiento) {
                    $('#errorFechaNacimiento').text(errors.fecha_nacimiento.join(' '));
                }
                if (errors.patente) {
                    $('#errorPatente').text(errors.patente.join(' '));
                }
                if (errors.contraseña) {
                    $('#errorContraseña').text(errors.contraseña.join(' '));
                }
            } else {
                alert("Error al crear el usuario");
            }
        }
    });
}

function editUsuario(id) {
    $.get(`/api/usuarios/${id}`, function(usuario) {
        $('#editUserId').val(usuario.id);
        $('#editNombre').val(usuario.nombre);
        $('#editApellido').val(usuario.apellido);
        $('#editDomicilio').val(usuario.domicilio);
        $('#editEmail').val(usuario.email);

        var fechaNacimiento = new Date(usuario.fecha_nacimiento);
        var day = ("0" + fechaNacimiento.getDate()).slice(-2);
        var month = ("0" + (fechaNacimiento.getMonth() + 1)).slice(-2);
        var formattedDate = fechaNacimiento.getFullYear() + "-" + (month) + "-" + (day);

        $('#editFechaNacimiento').val(formattedDate);
        $('#editPatente').val(usuario.patente);
        $('#editModal').show();
    });
}

function closeEditModal() {
    $('#editModal').hide();
}

function updateUsuario() {
    var id = $('#editUserId').val();
    var usuarioData = {
        nombre: $('#editNombre').val(),
        apellido: $('#editApellido').val(),
        domicilio: $('#editDomicilio').val(),
        email: $('#editEmail').val(),
        fecha_nacimiento: $('#editFechaNacimiento').val(),
        patente: $('#editPatente').val()
    };

    $.ajax({
        url: `/api/usuarios/${id}`,
        type: 'PUT',
        data: usuarioData,
        success: function(result) {
            alert("Usuario actualizado con éxito");
            $('#editModal').hide();
            $('#usuariosTable').DataTable().ajax.reload();
        },
        error: function(err) {
            alert("Error al actualizar el usuario");
        }
    });
}

function deleteUsuario(id) {
    if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
        $.ajax({
            url: `/api/usuarios/${id}`,
            type: 'DELETE',
            success: function(result) {
                alert("Usuario eliminado con éxito");
                $('#usuariosTable').DataTable().ajax.reload();
            },
            error: function(err) {
                alert("Error al eliminar el usuario");
            }
        });
    }
}
