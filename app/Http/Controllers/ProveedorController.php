<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{

    public function index(Request $request)
{
    $query = Proveedor::query();

    // Filtrar por estado (activo o inactivo)
    if ($request->has('status') && $request->status !== '') {
        $query->where('activo', $request->status);
    }

    // Filtrar por nombre o RUC
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('nombre', 'LIKE', "%{$search}%")
              ->orWhere('ruc', 'LIKE', "%{$search}%");
        });
    }

    // Paginación de los resultados
    $proveedores = $query->paginate(10);

    // Si la solicitud es AJAX, solo retornar la vista de la tabla
    if ($request->ajax()) {
        return response()->json([
            'view' => view('proveedores.proveedores_table', compact('proveedores'))->render()
        ]);
    }

    // Pasar los resultados a la vista con los filtros aplicados
    return view('proveedores.index', compact('proveedores'));
}



    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {

       $request->validate([
        'nombre' => 'required|string|max:255',
        'direccion' => 'required|string|max:255',
        'telefono' => 'required|string|max:20',
        'email' => 'required|email|unique:proveedores,email',
        'ruc' => 'required|string|size:11|unique:proveedores,ruc',
    ]);

    Proveedor::create($request->all());

    return redirect()->route('proveedores.index')->with('success', 'Proveedor agregado exitosamente.');
    }

    public function show(Proveedor $proveedor)
    {
        return view('proveedores.show', compact('proveedor'));
    }

    public function edit(Proveedor $proveedor)
    {
        return view('proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, Proveedor $proveedor)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'ruc' => 'required|string|max:11',
        ]);

        $proveedor->update($request->all());
        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado exitosamente.');
    }

    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();

        return redirect()->route('proveedores.index')
                         ->with('success', 'Proveedor eliminado exitosamente.');
    }

    public function desactivar($id) {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->activo = !$proveedor->activo;
        $proveedor->save();
        return redirect()->route('proveedores.index')->with('success', 'Estado actualizado.');
    }
    

}
