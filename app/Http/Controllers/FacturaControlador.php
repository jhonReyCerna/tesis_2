<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FacturaControlador extends Controller
{
    public function show($id)
    {
        $venta = Venta::with('cliente', 'detalles.producto')->findOrFail($id);


        $qrCodeFileName = 'qr_codes/factura_' . $venta->id_venta . '.png';
        $qrCodePath = storage_path('app/public/' . $qrCodeFileName);



        $qrCodeUrl = asset('storage/' . $qrCodeFileName);


        $pdf = Pdf::loadView('factura', compact('venta', 'qrCodeUrl'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('factura_' . $venta->id_venta . '.pdf');
    }
}
