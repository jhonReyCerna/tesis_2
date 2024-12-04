<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReporteventaController extends Controller
{

    public function reporteVentas(Request $request)
    {
        return view('reporteventa.reporte');
    }
}
