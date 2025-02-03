@extends('adminlte::page')

@section('title', 'Lista de Proveedores')

@section('content_header')
    <h1>Lista de Proveedores</h1>
@stop

@section('css')
    
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form class="mb-3">
        <div class="input-group">
            <input type="text" id="search" class="form-control" placeholder="Buscar por nombre o RUC">
        </div>
    </form>

    <a href="{{ route('proveedores.create') }}" class="btn btn-primary mb-3">Agregar Proveedor</a>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>RUC</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="proveedores-table">
                    @foreach($proveedores as $proveedor)
                        <tr>
                            <td>{{ $proveedor->nombre }}</td>
                            <td>{{ $proveedor->telefono }}</td>
                            <td>{{ $proveedor->ruc }}</td>
                            <td>{{ $proveedor->activo ? 'Activo' : 'Inactivo' }}</td>
                            <td>
                                <a href="{{ route('proveedores.show', $proveedor) }}" class="btn btn-info btn-sm">👁️</a>
                                <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn btn-warning btn-sm">✏️</a>
                                
                                <form action="{{ route('proveedores.desactivar', $proveedor) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        {{ $proveedor->activo ? '🔴' : '🟢' }}
                                    </button>
                                </form>
                                
                                <form action="{{ route('proveedores.destroy', $proveedor) }}" method="POST" style="display:inline;" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm delete-btn">🗑️</button>
                                </form>
                            </td>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {{ $proveedores->links() }}
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
    </script>
@stop
