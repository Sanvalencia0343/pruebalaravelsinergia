<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Usuarios</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="btn btn-outline-danger" href="{{ route('users.logout') }}">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2>Usuarios Registrados</h2>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table id="usuariosTable" class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo Electrónico</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>
                                @if($usuario->status === 1)
                                    Activo
                                @else
                                    Inactivo
                                @endif
                            </td>
                            <td>
                                @if($usuario->status === 1)
                                    <button class="btn btn-warning" onclick="cambiarEstado({{ $usuario->id }})">Inactivar</button>
                                @else
                                    <button class="btn btn-success" onclick="cambiarEstado({{ $usuario->id }})">Activar</button>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-danger" onclick="eliminarUsuario({{ $usuario->id }})">Eliminar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready( function () {
        $('#usuariosTable').DataTable();
    } );

    function cambiarEstado(userId) {
        $.ajax({
            type: 'POST',
            url:  userId + '/changestatus',
            data: {
                _token: '{{ csrf_token() }}',
            },
            success: function(data) {
                console.log(data);
                location.reload();
            },
            error: function(error) {
                console.error(error);
            }
        });
    }

    function eliminarUsuario(userId) {
        if (confirm('¿Estás seguro de eliminar este usuario?')) {
            $.ajax({
                type: 'DELETE',
                url:  userId,
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(data) {
                    console.log(data);
                    location.reload();
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
