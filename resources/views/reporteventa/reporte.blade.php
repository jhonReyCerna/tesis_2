@extends('adminlte::page')

@section('title', 'Reporte de ventas Gráficos')



@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfico de Ventas</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #343a40;
            margin-bottom: 20px;
        }
        .filters {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        .filters .form-group {
            flex: 1;
            min-width: 150px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #495057;
        }
        input, select, button {
            width: 100%;
            padding: 8px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }
        button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        .chart-container {
            margin-top: 30px;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Reporte de Ventas</h1>
        <div class="filters">
            <div class="form-group">
                <label for="tipoGrafico">Tipo de Gráfico:</label>
                <select id="tipoGrafico">
                    <option value="dia">Por Día</option>
                    <option value="mes">Por Mes</option>
                    <option value="año">Por Año</option>
                </select>
            </div>
            <div class="form-group">
                <label for="fechaInicio">Fecha de Inicio:</label>
                <input type="date" id="fechaInicio">
            </div>
            <div class="form-group">
                <label for="fechaFin">Fecha de Fin:</label>
                <input type="date" id="fechaFin">
            </div>
        </div>
        <button id="mostrarGrafico">Generar Gráfico</button>

        <div class="chart-container">
            <canvas id="ventasChart"></canvas>
        </div>
    </div>

    <footer>
        &copy; 2024 Sistema de Ventas. Todos los derechos reservados.
    </footer>

    <script>
        const ctx = document.getElementById('ventasChart').getContext('2d');

        const data = {
            labels: ['10/10', '11/10', '12/10', '13/10', '14/10', '15/10', '16/10', '17/10', '18/10', '19/10', '20/10', '21/10', '22/10', '23/10'],
            datasets: [
                {
                    type: 'bar',
                    label: 'Monto Total (S/)',
                    data: [9000, 8000, 7000, 7500, 8500, 6000, 9500, 8900, 7300, 9200, 8400, 7100, 8800, 9400],
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    type: 'line',
                    label: 'Tendencia',
                    data: [9000, 8000, 7000, 7500, 8500, 6000, 9500, 8900, 7300, 9200, 8400, 7100, 8800, 9400],
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    pointBackgroundColor: 'rgba(255, 99, 132, 1)',
                    pointRadius: 4
                }
            ]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Monto Total de Ventas por Día'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Monto Total (S/)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Fechas'
                        }
                    }
                }
            }
        };

        const ventasChart = new Chart(ctx, config);

        document.getElementById('mostrarGrafico').addEventListener('click', () => {
            alert('Funcionalidad de generación dinámica pendiente de implementación.');
        });
    </script>
</body>
</html>
@stop
