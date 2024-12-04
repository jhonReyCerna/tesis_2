<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportecompraController extends Controller
{
    public function reporteCompras(Request $request)
    {
        return view('reportecompra.reporte');
    }
}
