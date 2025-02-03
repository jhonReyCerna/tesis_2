@extends('adminlte::page')

@section('title', 'Detalles del Proveedor')

@section('content_header')
    <h1>Detalles del Proveedor</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $proveedor->id_proveedor }}</p>
            <p><strong>Nombre:</strong> {{ $proveedor->nombre }}</p>
            <p><strong>Dirección:</strong> {{ $proveedor->direccion }}</p>
            <p><strong>Teléfono:</strong> {{ $proveedor->telefono }}</p>
            <p><strong>Email:</strong> {{ $proveedor->email }}</p>
            <p><strong>RUC:</strong> {{ $proveedor->ruc }}</p>
            <p><strong>Estado:</strong> 
                <span class="badge {{ $proveedor->activo ? 'badge-success' : 'badge-danger' }}">
                    {{ $proveedor->activo ? 'Activo' : 'Inactivo' }}
                </span>
            </p>
        </div>
        <div class="card-footer">
            <a href="{{ route('proveedores.index') }}" class="btn btn-primary">Volver a la lista</a>
            <form action="{{ route('proveedores.desactivar', $proveedor) }}" method="POST" style="display:inline;">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-danger">{{ $proveedor->activo ? 'Desactivar' : 'Activar' }}</button>
            </form>
        </div>
    </div>
@stop
