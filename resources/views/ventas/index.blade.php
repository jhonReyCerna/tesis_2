@extends('adminlte::page')

@section('title', 'Ventas')

@section('content_header')
    <h1>Ventas</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form class="mb-3">
        <div class="input-group">
            <input type="text" id="search" class="form-control" placeholder="Buscar por cliente, total o fecha de venta">
        </div>
    </form>

    <a href="{{ route('ventas.create') }}" class="btn btn-primary mb-3">Nueva Venta</a>
    <a href="{{ route('ventas.reporte') }}" class="btn btn-success mb-3"> <i class="fas fa-file-pdf"></i> Generar Reporte PDF</a>
    <a href="public/tiempos/tiempo.xlsx" class="btn btn-info mb-3" download>
        <i class="fas fa-file-excel"></i> Generar Reporte Excel
      </a>
      
      
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nª</th>
                        <th>Cliente</th>
                        <th>Total Pagar</th>
                        <th>Fecha de Venta</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="ventas-table">
                    @foreach($ventas as $venta)
                        <tr>
                            <td>{{ $venta->id_venta }}</td>
                            <td>{{ $venta->cliente->nombre }}</td>
                            <td>{{ number_format($venta->totalPagar, 2) }}</td>
                            <td>{{ $venta->fecha_venta }}</td>
                            <td>{{ $venta->estado }}</td>
                            <td>
                                <a href="{{ route('ventas.show', $venta->id_venta) }}" class="btn btn-info btn-sm">Ver</a>
                                <a href="{{ route('ventas.edit', $venta->id_venta) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('ventas.destroy', $venta->id_venta) }}" method="POST" style="display:inline;" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm delete-btn">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {{ $ventas->links() }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.delete-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                const form = this.closest('.delete-form');
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¿Deseas eliminar esta venta?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        document.getElementById('search').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#ventas-table tr');

            rows.forEach(function(row) {
                const cliente = row.cells[1].textContent.toLowerCase();
                const totalPagar = row.cells[2].textContent.toLowerCase();
                const fechaVenta = row.cells[3].textContent.toLowerCase();

                if (cliente.includes(searchValue) || totalPagar.includes(searchValue) || fechaVenta.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Mostrar el Modal de Ayuda al presionar F1
        document.addEventListener('keydown', (event) => {
            if (event.key === 'F1') {
                event.preventDefault(); // Evita la acción predeterminada de F1.
                showHelpModal('ventas');
            }
        });

        function showHelpModal(section) {
            fetchHelpContent(section)
                .then(displayHelpContent)
                .catch(handleHelpError);
        }

        function fetchHelpContent(section) {
            console.log(`Fetching help content for section: ${section}`);
            return fetch(`/help/${section}`)
                .then((response) => {
                    console.log('Response received:', response);
                    if (!response.ok) {
                        throw new Error('No se encontró contenido de ayuda para esta sección.');
                    }
                    return response.json();
                });
        }

        function displayHelpContent(data) {
            console.log('Displaying help content:', data);
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
            
            // Crear elemento de alerta
            const alertElement = document.createElement('div');
            alertElement.className = 'alert-modal';
            
            // Añadir contenido con icono
            alertElement.innerHTML = `
                <div class="alert-content">
                    <i class="fas fa-info-circle alert-icon"></i>
                    <span>Pasando a la ayuda en línea...</span>
                </div>
            `;
            
            // Añadir al documento
            document.body.appendChild(alertElement);
            
            // Eliminar después de un retraso y redirigir
            setTimeout(() => {
                alertElement.style.animation = 'slideUp 0.5s ease-in forwards';
                setTimeout(() => {
                    alertElement.remove();
                    window.location.href = '{{ asset('ayuda/ventas.chm') }}';
                }, 500);
            }, 3000);
        }

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
@stop

<style>
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
            top: 250px; /* Increased from 120px to 250px to appear lower */
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
            top: 250px; /* Match the new position */
            opacity: 1;
        }
        100% {
            top: -100px;
            opacity: 0;
        }
    }
</style>
