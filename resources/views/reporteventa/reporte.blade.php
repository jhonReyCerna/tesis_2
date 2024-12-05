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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
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
        input, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }
    
        /* Estilos para los botones */
        button {
            padding: 12px 20px;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2), 0 1px 4px rgba(0, 123, 255, 0.15);
            text-align: center;
            width: auto;
            display: inline-block;
        }
    
        /* Botón para generar el gráfico */
        #mostrarGrafico {
            background-color: #007bff;
            color: white;
        }
    
        #mostrarGrafico:hover {
            background-color: #0056b3;
            box-shadow: 0 6px 12px rgba(0, 123, 255, 0.3);
        }
    
        /* Botón para descargar PDF */
        #descargarPDF {
            background-color: #28a745;
            color: white;
        }
    
        #descargarPDF:hover {
            background-color: #218838;
            box-shadow: 0 6px 12px rgba(40, 167, 69, 0.3);
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
        <button id="descargarPDF">Descargar PDF</button>

        <div class="chart-container">
            <canvas id="ventasChart"></canvas>
        </div>
    </div>

    <footer>
        &copy; 2024 Sistema de Ventas. Todos los derechos reservados.
    </footer>

    <script>
        const ctx = document.getElementById('ventasChart').getContext('2d');

        let ventasChart;

        // Función para generar datos simulados con base en las fechas
        function obtenerDatosSimulados(fechaInicio, fechaFin, tipoGrafico) {
            const fechas = [];
            const valores = [];

            let fechaActual = new Date(fechaInicio);
            const fechaFinDate = new Date(fechaFin);

            while (fechaActual <= fechaFinDate) {
                if (tipoGrafico === 'dia') {
                    fechas.push(fechaActual.toISOString().split('T')[0]);
                    valores.push(Math.floor(Math.random() * 100) + 50); // Valores aleatorios por día

                    // Incrementar día
                    fechaActual.setDate(fechaActual.getDate() + 1);
                } else {
                    const mes = fechaActual.toLocaleString('default', { month: 'long', year: 'numeric' });
                    fechas.push(mes);
                    valores.push(Math.floor(Math.random() * 1000) + 500); // Valores aleatorios por mes

                    // Incrementar mes
                    fechaActual.setMonth(fechaActual.getMonth() + 1);
                }
            }

            return { fechas, valores };
        }

        // Configuración inicial del gráfico
        function crearGrafico(fechas, valores) {
            if (ventasChart) ventasChart.destroy();

            ventasChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: fechas,
                    datasets: [
                        {
                            type: 'bar',
                            label: 'Cantidad de Ventas',
                            data: valores,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            type: 'line',
                            label: 'Tendencia',
                            data: valores,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 2,
                            tension: 0.4,
                            pointBackgroundColor: 'rgba(255, 99, 132, 1)',
                            pointRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Ventas dinámicas según el rango de fechas'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Cantidad de Ventas'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: tipoGrafico === 'dia' ? 'Días' : 'Meses'
                            }
                        }
                    }
                }
            });
        }

        document.getElementById('mostrarGrafico').addEventListener('click', () => {
            const tipoGrafico = document.getElementById('tipoGrafico').value;
            const fechaInicio = document.getElementById('fechaInicio').value;
            const fechaFin = document.getElementById('fechaFin').value;

            if (!fechaInicio || !fechaFin) {
                alert('Por favor, selecciona un rango de fechas.');
                return;
            }

            const { fechas, valores } = obtenerDatosSimulados(fechaInicio, fechaFin, tipoGrafico);
            crearGrafico(fechas, valores);
        });

        document.getElementById('descargarPDF').addEventListener('click', () => {
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF();

            pdf.text("Reporte de Ventas", 10, 10);

            const canvas = document.getElementById('ventasChart');
            const imgData = canvas.toDataURL("image/png");

            pdf.addImage(imgData, 'PNG', 10, 20, 180, 100);
            pdf.save("Reporte_Ventas.pdf");
        });
    </script>
</body>
</html>
@stop
