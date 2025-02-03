@extends('adminlte::page')

@section('title', 'Detalles de Categoría')

@section('content_header')
    <h1>Detalles de la Categoría</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $categoria->id_categoria }}</p>
            <p><strong>Nombre:</strong> {{ $categoria->nombre }}</p>
            <p><strong>Descripción:</strong> {{ $categoria->descripcion }}</p>
            <p><strong>Estado:</strong> 
                <span class="badge {{ $categoria->activo ? 'badge-success' : 'badge-danger' }}">
                    {{ $categoria->activo ? 'Activo' : 'Inactivo' }}
                </span>
            </p>
        </div>
        <div class="card-footer">
            <a href="{{ route('categorias.index') }}" class="btn btn-primary">Regresar</a>
            <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-warning">Editar</a>
        </div>
    </div>
@stop
