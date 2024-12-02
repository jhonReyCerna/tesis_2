@extends('adminlte::page')

{{-- Add meta tags and common CSS --}}
@push('css')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style type="text/css">
        .card-header {
            border-bottom: none;
        }
        .card-title {
            font-weight: 600;
        }
        .content-header h1 {
            font-size: 1.8rem;
            margin: 0;
        }
        .footer {
            padding: 1rem;
            background: #fff;
            border-top: 1px solid #dee2e6;
        }
    </style>
@endpush

{{-- Extend and customize the browser title --}}

@section('title')
    {{ config('adminlte.title') }}
    @hasSection('subtitle') | @yield('subtitle') @endif
@stop

{{-- Extend and customize the page content header --}}

@section('content_header')
    @hasSection('content_header_title')
        <h1 class="text-muted">
            @yield('content_header_title')

            @hasSection('content_header_subtitle')
                <small class="text-dark">
                    <i class="fas fa-xs fa-angle-right text-muted"></i>
                    @yield('content_header_subtitle')
                </small>
            @endif
        </h1>
    @endif
@stop

{{-- Rename section content to content_body --}}

@section('content')
    @yield('content_body')
@stop

{{-- Create a common footer --}}

@section('footer')
    <div class="footer">
        <div class="float-right">
            Version: {{ config('app.version', '1.0.0') }}
        </div>

        <strong>
            <a href="{{ config('app.company_url', '#') }}">
                {{ config('app.company_name', 'My company') }}
            </a>
        </strong>
    </div>
@stop

{{-- Add updated JavaScript dependencies --}}
@push('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
            
            // Add your common script logic here...
        });
    </script>
@endpush