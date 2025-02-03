@extends('adminlte::page')

@section('title', 'Detalles del Proveedor')

@section('content_header')
    <h1>Detalles del Proveedor</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <h4>ID: {{ $proveedor->id_proveedor }}</h4>
            <h4>Nombre: {{ $proveedor->nombre }}</h4>
            <h4>Dirección: {{ $proveedor->direccion }}</h4>
            <h4>Teléfono: {{ $proveedor->telefono }}</h4>
            <h4>Email: {{ $proveedor->email }}</h4>
            <h4>RUC: {{ $proveedor->ruc }}</h4>
            <h4>Estado: {{ $proveedor->activo ? 'Activo' : 'Inactivo' }}</h4>
        </div>
    </div>
    <a href="{{ route('proveedores.index') }}" class="btn btn-primary">Volver a la lista</a>
    <form action="{{ route('proveedores.desactivar', $proveedor) }}" method="POST" style="display:inline;">
        @csrf
        @method('PUT')
        <button type="submit" class="btn btn-danger">{{ $proveedor->activo ? 'Desactivar' : 'Activar' }}</button>
    </form>
@stop
