<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comercios</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        /* Estilos para la tabla y botones */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            margin-top: 20px;
        }
        h2 {
            color: #333;
        }
        .btn {
            margin-right: 5px;
        }
        .btn-create {
            background-color: #28a745;
            color: #fff;
        }
        .btn-edit, .btn-delete {
            color: #fff;
        }
        .btn-edit {
            background-color: #007bff;
        }
        .btn-delete {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Lista de Comercios</h2>
    <button class="btn btn-create" onclick="openCreateModal()">Crear Nuevo Comercio</button>
    <table id="comerciosTable" class="display">
        <thead>
            <tr>
                <th>CUIT</th>
                <th>Razón Social</th>
                <th>Dirección</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Contenido generado por DataTables -->
        </tbody>
    </table>
</div>

<!-- Modal para crear y editar comercio -->
<div id="comercioModal" style="display:none;">
    <div>
        <h3 id="modalTitle">Crear Comercio</h3>
        <form id="comercioForm">
            <input type="hidden" id="comercioId">
            <div>
                <label for="cuit">CUIT:</label>
                <input type="text" id="cuit" name="cuit" required>
            </div>
            <div>
                <label for="razon_social">Razón Social:</label>
                <input type="text" id="razon_social" name="razon_social" required>
            </div>
            <div>
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" required>
            </div>
            <button type="button" onclick="saveComercio()">Guardar</button>
            <button type="button" onclick="closeComercioModal()">Cancelar</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('js/comercios.js') }}"></script>
</body>
</html>
