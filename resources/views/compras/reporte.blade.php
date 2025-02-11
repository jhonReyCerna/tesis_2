<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Compras</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 40px;
            background-color: white;
        }

        .header-container {
            position: relative;
            border-bottom: 2px solid #1a237e;
            margin-bottom: 30px;
            padding-bottom: 20px;
            min-height: 180px;
        }

        .header {
            width: 60%;
        }

        .header h1 {
            color: #ffe608;
            font-size: 24px;
            margin: 0;
        }

        .header h2 {
            color: #424242;
            font-size: 18px;
            margin: 5px 0 0;
            font-weight: normal;
        }

        .logo {
            position: absolute;
            top: 0;
            right: 0;
            max-height: 170px;
            width: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
        }

        th {
            background-color: #ffee01;
            color: rgb(41, 6, 6);
            padding: 12px;
            font-weight: 500;
            text-align: left;
            font-size: 14px;
        }

        td {
            padding: 10px 12px;
            border-bottom: 1px solid #fefb21;
            color: #424242;
            font-size: 13px;
        }

        tr:nth-child(even) {
            background-color: #fcfeb1;
        }

        .numeric {
            text-align: right;
            font-family: 'Arial', sans-serif;
            font-weight: 500;
        }

        .details {
            margin-top: 30px;
            text-align: right;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #e0e0e0;
            padding-top: 15px;
        }

        @media print {
            body {
                padding: 20px;
            }
            th {
                background-color: #1a237e !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="header-container">
        <div class="header">
            <h1>Tienda La Curacao</h1>
            <h2>Reporte de Compras</h2>
        </div>
        <img class="logo" src="{{ public_path('vendor/adminlte/dist/img/curacao.jpg') }}" alt="Logo de la tienda">
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Proveedor</th>
                <th>Cantidad</th>
                <th>Fecha</th>
                <th>Almacén</th>
                <th>Precio Unit.</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($compras as $compra)
                <tr>
                    <td>{{ str_pad($compra->id_compra, 6, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $compra->producto->nombre }}</td>
                    <td>{{ $compra->proveedor->nombre }}</td>
                    <td class="numeric">{{ number_format($compra->cantidad, 0) }}</td>
                    <td>{{ \Carbon\Carbon::parse($compra->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $compra->almacen->nombre }}</td>
                    <td class="numeric">S/ {{ number_format($compra->precio_unitario, 2) }}</td>
                    <td class="numeric">S/ {{ number_format($compra->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="details">
        <?php date_default_timezone_set('America/Lima'); ?>
        <p>Reporte generado el {{ \Carbon\Carbon::now()->format('d/m/Y') }} a las {{ \Carbon\Carbon::now()->format('H:i:s') }} / Lima, Perú</p>
    </div>
</body>
</html>
