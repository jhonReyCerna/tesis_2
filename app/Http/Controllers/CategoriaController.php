<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index(Request $request)
{
    $query = Categoria::query();

    // Filtro por nombre o descripción
    if ($request->has('search') && $request->search) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('nombre', 'like', "%{$search}%")
              ->orWhere('descripcion', 'like', "%{$search}%");
        });
    }

    // Filtro por estado
    if ($request->has('status') && $request->status !== '') {
        $query->where('activo', $request->status);
    }

    $categorias = $query->paginate(10);
    return view('categorias.index', compact('categorias'));
}


    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        Categoria::create([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
        ]);

        return redirect()->route('categorias.index')->with('success', 'Categoría creada exitosamente');
    }

    public function show($id)
    {
        $categoria = Categoria::findOrFail($id);

        return view('categorias.show', compact('categoria'));
    }

    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);

        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->update([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
        ]);

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada exitosamente');
    }

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada exitosamente');
    }

    public function desactivar(Categoria $categoria)
    {
        // Cambiar el estado de la categoría (si está activa, la desactiva, y viceversa)
        
        $categoria->activo = !$categoria->activo;
        $categoria->save();

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada correctamente');
    }
}
