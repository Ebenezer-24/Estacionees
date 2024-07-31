<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recargas</title>
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
            margin: 20px;
        }
        h2 {
            color: #d32f2f;
        }
        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 10px;
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
            background-color: #4CAF50;
            border-color: #4CAF50;
            color: #fff;
        }
        .btn-create:hover {
            background-color: #45A049;
            border-color: #398439;
        }
        .btn-edit {
            background-color: #5bc0de;
            border-color: #46b8da;
            color: #fff;
        }
        .btn-edit:hover {
            background-color: #31b0d5;
            border-color: #269abc;
        }
        .btn-delete {
            background-color: #d9534f;
            border-color: #d43f3a;
            color: #fff;
        }
        .btn-delete:hover {
            background-color: #c9302c;
            border-color: #ac2925;
        }
        #recargaModal {
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
        #modalContent {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
        }
        #modalContent h3 {
            color: #d32f2f;
            margin-top: 0;
        }
        #recargaForm div {
            margin-bottom: 10px;
        }
        label {
            display: block;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"] {
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
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
        }
        button[type="button"]:hover {
            background-color: #45A049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Lista de Recargas</h2>
        <button class="btn btn-create" onclick="openRecargaModal()">Crear Nueva Recarga</button>
        <table id="recargasTable" class="display">
            <thead>
                <tr>
                    <th>ID Comercio</th>
                    <th>DNI Usuario</th>
                    <th>Patente</th>
                    <th>Importe</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Cuerpo de la tabla se llenará mediante JavaScript -->
            </tbody>
        </table>
    </div>

    <!-- Modal para crear/editar recarga -->
    <div id="recargaModal">
        <div id="modalContent">
            <h3>Crear/Editar Recarga</h3>
            <form id="recargaForm">
                <input type="hidden" id="recargaId">
                <div>
                    <label for="comercioId">ID Comercio:</label>
                    <input type="text" id="comercioId" name="comercio_id" required>
                </div>
                <div>
                    <label for="dniUsuario">DNI Usuario:</label>
                    <input type="text" id="dniUsuario" name="dni" required>
                </div>
                <div>
                    <label for="patente">Patente:</label>
                    <input type="text" id="patente" name="patente" required>
                </div>
                <div>
                    <label for="importe">Importe:</label>
                    <input type="number" id="importe" name="importe" step="0.01" required>
                </div>
                <button type="button" onclick="guardarRecarga()">Guardar</button>
                <button type="button" onclick="closeRecargaModal()">Cancelar</button>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/recargas.js') }}"></script>
</body>
</html>
