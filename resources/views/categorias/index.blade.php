@extends('adminlte::page')

@section('title', 'Lista de Categorías')

@section('content_header')
    <h1>Lista de Categorías</h1>
@stop

@section('css')
    
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form class="mb-3" method="GET">
        <div class="input-group">
            <input type="text" id="search" class="form-control" placeholder="Buscar por nombre o descripción" value="{{ request('search') }}">
            <select id="status-filter" name="status" class="form-control ml-2">
                <option value="">Filtrar por estado</option>
                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactivo</option>
            </select>
            <button type="submit" class="btn btn-primary ml-2">Filtrar</button>
        </div>
    </form>

    <a href="{{ route('categorias.create') }}" class="btn btn-primary mb-3">Agregar Categoría</a>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nª</th>
                        <th>Categoría</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="categorias-table">
                    @foreach($categorias as $categoria)
                        <tr>
                            <td>{{ $categoria->id_categoria }}</td>
                            <td>{{ $categoria->nombre }}</td>
                            <td>{{ $categoria->descripcion }}</td>
                            <td>{{ $categoria->activo ? 'Activo' : 'Inactivo' }}</td>
                            <td>
                                <a href="{{ route('categorias.show', $categoria) }}" class="btn btn-info btn-sm">👁️</a>
                                <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-warning btn-sm">✏️</a>

                                <form action="{{ route('categorias.desactivar', $categoria) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        {{ $categoria->activo ? '🔴' : '🟢' }}
                                    </button>
                                </form>

                                <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" style="display:inline;" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm delete-btn">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {{ $categorias->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Manejar el evento de eliminación con confirmación
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form'); // Obtiene el formulario de eliminación

                // Mostrar el SweetAlert de confirmación
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: '¡Esta acción no se puede deshacer!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'No, cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Si el usuario confirma, enviar el formulario
                        form.submit();
                    }
                });
            });
        });

        // Filtrar categorías por nombre o descripción en tiempo real
        document.getElementById('search').addEventListener('input', function() {
            const search = this.value.toLowerCase(); // Obtener el texto ingresado
            const rows = document.querySelectorAll('#categorias-table tr'); // Obtener todas las filas

            rows.forEach(row => {
                const nombre = row.cells[1]?.textContent.toLowerCase(); // Nombre de la categoría
                const descripcion = row.cells[2]?.textContent.toLowerCase(); // Descripción de la categoría

                // Verificar si el texto de búsqueda coincide con el nombre o descripción
                if (nombre.includes(search) || descripcion.includes(search)) {
                    row.style.display = ''; // Mostrar la fila si hay coincidencia
                } else {
                    row.style.display = 'none'; // Ocultar la fila si no hay coincidencia
                }
            });
        });
    </script>
@stop
