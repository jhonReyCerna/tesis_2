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
                <span class="info-box-number">${{ number_format(230548, 2) }}</span>
            </div>
        </div>
    </div>
</div>

 
<div class="row mt-4">
     <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ventas Mensuales 2024</h3>
            </div>
            <div class="card-body">
                <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>

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

 

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tendencia de Ventas</h3>
        </div>
        <div class="card-body">
            <canvas id="trendChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
    </div>
</div>

 <div id="overlay"></div>
<div id="helpModal">
    <div id="helpContent"></div>
    <button onclick="closeHelpModal()">Cerrar</button>
</div>

@stop

@push('css')
<style>
     #overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        display: none;
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }

    #helpModal {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.8);
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        max-width: 500px;
        width: 80%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        display: none;
        transition: transform 0.5s ease-in-out;
    }

    #helpContent {
        font-size: 16px;
        color: #333;
        line-height: 1.6;
    }

     .alert-modal {
        position: fixed;
        top: -100px;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(135deg, #00b4db, #0083b0);
        color: white;
        padding: 20px 40px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        opacity: 0;
        animation: slideDown 0.5s ease-out forwards,
                   pulse 2s infinite;
    }

    @keyframes slideDown {
        0% {
            top: -100px;
            opacity: 0;
        }
        100% {
            top: 250px;  
            opacity: 1;
        }
    }

    @keyframes pulse {
        0% { transform: translateX(-50%) scale(1); }
        50% { transform: translateX(-50%) scale(1.05); }
        100% { transform: translateX(-50%) scale(1); }
    }

    .alert-content {
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 16px;
    }

    .alert-icon {
        font-size: 24px;
        animation: rotate 2s infinite linear;
    }

    @keyframes rotate {
        100% { transform: rotate(360deg); }
    }

    @keyframes slideUp {
        0% {
            top: 250px;  
            opacity: 1;
        }
        100% {
            top: -100px;
            opacity: 0;
        }
    }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Agosto', 'Septiembre', 'Octubre', 'Noviembre'],
                datasets: [{
                    label: 'Ventas Mensuales 2024',
                    data: [410, 480, 530, 580],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var trendCtx = document.getElementById('trendChart').getContext('2d');
        var trendChart = new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: ['Agosto', 'Septiembre', 'Octubre', 'Noviembre'],
                datasets: [{
                    label: 'Tendencia de Ventas',
                    data: [410, 480, 530, 580],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });

     new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: {
            labels: ['Electrónicos', 'Televisores', 'Computadoras y Laptops', 'Otros'],
            datasets: [{
                data: [30, 20, 25, 25],
                backgroundColor: ['#dc3545', '#28a745', '#ffc107', '#17a2b8']
            }]
        }
    });

 
    

     document.addEventListener('keydown', (event) => {
        if (event.key === 'F1') {
            event.preventDefault(); 
            showHelpModal('dashboard');
        }
    });

    function showHelpModal(section) {
        fetchHelpContent(section)
            .then(displayHelpContent)
            .catch(handleHelpError);
    }

    function fetchHelpContent(section) {
        return fetch(`/help/${section}`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error('No se encontró contenido de ayuda para esta sección.');
                }
                return response.json();
            });
    }

    function displayHelpContent(data) {
        const helpContentElement = document.getElementById('helpContent');
        const overlayElement = document.getElementById('overlay');
        const helpModalElement = document.getElementById('helpModal');

        if (!data || !data.content) {
            throw new Error('El contenido de ayuda está vacío o no es válido.');
        }

        helpContentElement.textContent = data.content;

        overlayElement.style.opacity = 0;
        helpModalElement.style.transform = 'scale(0.8)';
        overlayElement.style.display = 'block';
        helpModalElement.style.display = 'block';

        setTimeout(() => {
            overlayElement.style.transition = 'opacity 0.5s ease-in-out';
            helpModalElement.style.transition = 'transform 0.5s ease-in-out';
            overlayElement.style.opacity = 0.7;
            helpModalElement.style.transform = 'scale(1)';
        }, 10);
    }

    function handleHelpError(error) {
        console.error('Error al cargar contenido de ayuda:', error.message);
        
         const alertElement = document.createElement('div');
        alertElement.className = 'alert-modal';
        
         alertElement.innerHTML = `
            <div class="alert-content">
                <i class="fas fa-info-circle alert-icon"></i>
                <span>Pasando a la ayuda en línea...</span>
            </div>
        `;
        
         document.body.appendChild(alertElement);
        
         setTimeout(() => {
            alertElement.style.animation = 'slideUp 0.5s ease-in forwards';
            setTimeout(() => {
                alertElement.remove();
                window.location.href = 'https://www.lacuracao.pe/centro-de-ayuda?srsltid=AfmBOooAKivZ6ycskwL2ARw1NQbePl3tV-NQx82Xjk2ra2Li-Avp0Bcy';
            }, 500);
        }, 3000);
    }

     const style = document.createElement('style');
    style.textContent = `
        @keyframes slideUp {
            0% {
                top: 120px;
                opacity: 1;
            }
            100% {
                top: -100px;
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);

    function closeHelpModal() {
        const overlayElement = document.getElementById('overlay');
        const helpModalElement = document.getElementById('helpModal');

        overlayElement.style.opacity = 0;
        helpModalElement.style.transform = 'scale(0.8)';

        setTimeout(() => {
            overlayElement.style.display = 'none';
            helpModalElement.style.display = 'none';
        }, 500);
    }
</script>
@endpush
