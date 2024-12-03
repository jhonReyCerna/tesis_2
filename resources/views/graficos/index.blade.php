@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard Estadístico</h1>
@stop

@section('content')
    {{-- Info Boxes --}}
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-info">
                <span class="info-box-icon"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Clientes</span>
                    <span class="info-box-number">{{ App\Models\Cliente::count() }}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-success">
                <span class="info-box-icon"><i class="fas fa-shopping-cart"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Ventas</span>
                    <span class="info-box-number">{{ App\Models\Venta::count() }}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-warning">
                <span class="info-box-icon"><i class="fas fa-chart-pie"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Productos</span>
                    <span class="info-box-number">{{ App\Models\Producto::count() }}</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-danger">
                <span class="info-box-icon"><i class="fas fa-chart-line"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Ingresos</span>
                    <span class="info-box-number">${{ number_format(rand(100000, 1000000), 2) }}</span>                </div>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="row mt-4">
        {{-- Bar Chart --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ventas Mensuales</h3>
                </div>
                <div class="card-body">
                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>

        {{-- Pie Chart --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Distribución de Productos</h3>
                </div>
                <div class="card-body">
                    <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Line Chart --}}
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tendencia de Ingresos</h3>
                </div>
                <div class="card-body">
                    <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Bar Chart
        new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
                datasets: [{
                    label: 'Ventas',
                    data: [65, 59, 80, 81, 56, 55],
                    backgroundColor: '#007bff'
                }]
            }
        });

        // Pie Chart
        new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: {
                labels: ['Electrónicos', 'Ropa', 'Alimentos', 'Otros'],
                datasets: [{
                    data: [30, 20, 25, 25],
                    backgroundColor: ['#dc3545', '#28a745', '#ffc107', '#17a2b8']
                }]
            }
        });

        // Line Chart
        new Chart(document.getElementById('lineChart'), {
            type: 'line',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
                datasets: [{
                    label: 'Ingresos',
                    data: [1000, 2000, 1500, 2500, 2200, 3000],
                    borderColor: '#28a745',
                    tension: 0.1
                }]
            }
        });
    </script>
@stop
