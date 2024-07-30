<!DOCTYPE html>
<html>
<head>
    <title>Lista de Usuarios</title>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }
        .container {
            margin-top: 20px;
        }
        h2 {
            color: #d32f2f;
        }
        table.dataTable thead {
            background-color: #424242;
            color: #fff;
        }
        table.dataTable tbody tr {
            background-color: #fafafa;
        }
        table.dataTable tbody tr:nth-child(odd) {
            background-color: #eeeeee;
        }
        table.dataTable tbody tr:hover {
            background-color: #f5f5f5;
        }
        table.dataTable thead th {
            border-bottom: none;
        }
        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: normal;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            border: 1px solid transparent;
            border-radius: 4px;
            user-select: none;
            text-decoration: none;
            margin-right: 5px;
        }
        .btn-create {
            background-color: #d32f2f;
            border-color: #d32f2f;
            color: #fff;
        }
        .btn-create:hover {
            background-color: #c12727;
            border-color: #b71c1c;
        }
        .btn-edit {
            background-color: #616161;
            border-color: #616161;
            color: #fff;
        }
        .btn-edit:hover {
            background-color: #494949;
            border-color: #424242;
        }
        .btn-delete {
            background-color: #b71c1c;
            border-color: #b71c1c;
            color: #fff;
        }
        .btn-delete:hover {
            background-color: #a21313;
            border-color: #8e0e0e;
        }
        #editModal, #createModal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.6);
        }
        #editModalContent, #createModalContent {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
        }
        #editModalContent h3, #createModalContent h3 {
            color: #d32f2f;
            margin-top: 0;
        }
        #editForm div, #createForm div {
            margin-bottom: 10px;
        }
        label {
            display: block;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .text-error {
            color: red;
            font-size: 0.875em;
            margin-top: 5px;
            display: block;
        }
        button {
            cursor: pointer;
        }
        button[type="button"] {
            background-color: #d32f2f;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
        }
        button[type="button"]:hover {
            background-color: #c12727;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Lista de Usuarios</h2>
        <button class="btn btn-create" onclick="openCreateModal()">Crear Nuevo Usuario</button>
        <table id="usuariosTable" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Domicilio</th>
                    <th>Email</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Patente</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Cuerpo de la tabla se llenará mediante JavaScript -->
            </tbody>
        </table>
    </div>

    <!-- Modal para editar usuario -->
    <div id="editModal">
        <div id="editModalContent">
            <h3>Editar Usuario</h3>
            <form id="editForm">
                <input type="hidden" id="editUserId">
                <div>
                    <label for="editNombre">Nombre:</label>
                    <input type="text" id="editNombre" name="nombre">
                </div>
                <div>
                    <label for="editApellido">Apellido:</label>
                    <input type="text" id="editApellido" name="apellido">
                </div>
                <div>
                    <label for="editDomicilio">Domicilio:</label>
                    <input type="text" id="editDomicilio" name="domicilio">
                </div>
                <div>
                    <label for="editEmail">Email:</label>
                    <input type="email" id="editEmail" name="email">
                </div>
                <div>
                    <label for="editFechaNacimiento">Fecha de Nacimiento:</label>
                    <input type="date" id="editFechaNacimiento" name="fecha_nacimiento">
                </div>
                <div>
                    <label for="editPatente">Patente:</label>
                    <input type="text" id="editPatente" name="patente">
                </div>
                <button type="button" onclick="updateUsuario()">Guardar Cambios</button>
                <button type="button" onclick="closeEditModal()">Cancelar</button>
            </form>
        </div>
    </div>

    <!-- Modal para crear usuario -->
    <div id="createModal">
        <div id="createModalContent">
            <h3>Crear Nuevo Usuario</h3>
            <form id="createForm">
                <div>
                    <label for="createDni">DNI:</label>
                    <input type="text" id="createDni" name="dni" required>
                    <span id="errorDni" class="text-error"></span>
                </div>
                <div>
                    <label for="createNombre">Nombre:</label>
                    <input type="text" id="createNombre" name="nombre" required>
                    <span id="errorNombre" class="text-error"></span>
                </div>
                <div>
                    <label for="createApellido">Apellido:</label>
                    <input type="text" id="createApellido" name="apellido" required>
                    <span id="errorApellido" class="text-error"></span>
                </div>
                <div>
                    <label for="createDomicilio">Domicilio:</label>
                    <input type="text" id="createDomicilio" name="domicilio" required>
                    <span id="errorDomicilio" class="text-error"></span>
                </div>
                <div>
                    <label for="createEmail">Email:</label>
                    <input type="email" id="createEmail" name="email" required>
                    <span id="errorEmail" class="text-error"></span>
                </div>
                <div>
                    <label for="createFechaNacimiento">Fecha de Nacimiento:</label>
                    <input type="date" id="createFechaNacimiento" name="fecha_nacimiento" required>
                    <span id="errorFechaNacimiento" class="text-error"></span>
                </div>
                <div>
                    <label for="createPatente">Patente:</label>
                    <input type="text" id="createPatente" name="patente">
                    <span id="errorPatente" class="text-error"></span>
                </div>
                <div>
                    <label for="createContraseña">Contraseña:</label>
                    <input type="password" id="createContraseña" name="contraseña" required>
                    <span id="errorContraseña" class="text-error"></span>
                </div>
                <button type="button" onclick="createUsuario()">Crear Usuario</button>
                <button type="button" onclick="closeCreateModal()">Cancelar</button>
            </form>
        </div>
    </div>

    
    <script src="{{ asset('js/usuarios.js') }}"></script>
</body>
</html>
