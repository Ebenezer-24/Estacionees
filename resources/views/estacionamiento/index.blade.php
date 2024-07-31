<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Estacionamientos</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- Custom CSS -->
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
        .btn {
            display: inline-block;
            padding: 6px 12px;
            font-size: 14px;
            text-align: center;
            cursor: pointer;
            border: 1px solid transparent;
            border-radius: 4px;
            text-decoration: none;
            margin-right: 5px;
        }
        .btn-create {
            background-color: #d32f2f;
            color: #fff;
        }
        .btn-edit {
            background-color: #616161;
            color: #fff;
        }
        .btn-delete {
            background-color: #b71c1c;
            color: #fff;
        }
        .modal {
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
        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 5px;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input[type="text"], input[type="datetime-local"], select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Gestión de Estacionamientos</h2>
        <button class="btn btn-create" onclick="openCreateModal()">Crear Nuevo Estacionamiento</button>
        <table id="estacionamientosTable" class="display">
            <thead>
                <tr>
                    <th>Número de Espacio</th>
                    <th>Patente</th>
                    <th>Hora de Inicio</th>
                    <th>Hora de Fin</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Cuerpo de la tabla será llenado por JavaScript -->
            </tbody>
        </table>
    </div>

    <!-- Modal para crear y editar estacionamiento -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <h3 id="modal-title"></h3>
            <form id="modal-form">
                <input type="hidden" id="modal-id">
                <div>
                    <label for="modal-espacio">Número de Espacio:</label>
                    <input type="text" id="modal-espacio" name="numero_espacio" required>
                </div>
                <div>
                    <label for="modal-patente">Patente:</label>
                    <input type="text" id="modal-patente" name="patente" required>
                </div>
                <div>
                    <label for="modal-inicio">Hora de Inicio:</label>
                    <input type="datetime-local" id="modal-inicio" name="hora_inicio" required>
                </div>
                <div>
                    <label for="modal-fin">Hora de Fin:</label>
                    <input type="datetime-local" id="modal-fin" name="hora_fin" required>
                </div>
                <button type="button" onclick="submitForm()">Guardar</button>
                <button type="button" onclick="closeModal()">Cancelar</button>
            </form>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/estacionamientos.js') }}"></script>
</body>
</html>
