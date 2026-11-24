<?php

namespace App\Http\Controllers;

use App\Models\Medicina;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Controlador MedicinaController
 * 
 * Orquesta las operaciones CRUD (Crear, Leer, Actualizar, Eliminar) 
 * para el módulo de inventario de medicamentos en FarmaStock.
 */
class MedicinaController extends Controller
{
    /**
     * Muestra el listado general de medicinas con Eager Loading de categorías.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Optimizamos la consulta trayendo la categoría relacionada en una sola ejecución
        $medicinas = Medicina::with('categoria')->orderBy('created_at', 'desc')->get();
        return view('medicinas.index', compact('medicinas'));
    }

    /**
     * Muestra el formulario para registrar un nuevo fármaco.
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('medicinas.create', compact('categorias'));
    }

    /**
     * Almacena un nuevo registro de medicina aplicando control transaccional (ACID).
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Validación estricta de los datos de entrada según el esquema SQL
        $request->validate([
            'codigo'           => 'required|unique:medicinas,codigo|max:50',
            'nombre'           => 'required|max:150',
            'categoria_id'     => 'required|exists:categorias,id',
            'precio_unitario'  => 'required|numeric|min:0',
            'stock_minimo'     => 'nullable|integer|min:0',
        ]);

        // 2. Transacción de base de datos para asegurar integridad ante fallos
        DB::beginTransaction();

        try {
            Medicina::create([
                'codigo'           => $request->codigo,
                'nombre'           => $request->nombre,
                'categoria_id'     => $request->categoria_id,
                'principio_activo' => $request->principio_activo,
                'presentacion'     => $request->presentacion,
                'laboratorio'      => $request->laboratorio,
                'precio_unitario'  => $request->precio_unitario,
                'stock_minimo'     => $request->stock_minimo ?? 5,
                'stock_total'      => 0, // Inicia en 0 hasta registrar entradas en almacén
                'requiere_recipe'  => $request->has('requiere_recipe') ? true : false,
            ]);

            DB::commit();

            return redirect()->route('medicinas.index')
                             ->with('success', 'Medicina registrada exitosamente.');

        } catch (\Exception $e) { 
            DB::rollBack();
            return back()->withErrors(['error' => 'Error crítico al registrar la medicina: ' . $e->getMessage()])
                         ->withInput();
        }
    }

    /**
     * Muestra el formulario de edición con los datos actuales de la medicina.
     * 
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $medicina = Medicina::findOrFail($id);
        $categorias = Categoria::all();
        return view('medicinas.edit', compact('medicina', 'categorias'));
    }

    /**
     * Actualiza la información del fármaco seleccionado.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $medicina = Medicina::findOrFail($id);

        $request->validate([
            'codigo'           => 'required|max:50|unique:medicinas,codigo,' . $medicina->id,
            'nombre'           => 'required|max:150',
            'categoria_id'     => 'required|exists:categorias,id',
            'precio_unitario'  => 'required|numeric|min:0',
        ]);

        $medicina->update([
            'codigo'           => $request->codigo,
            'nombre'           => $request->nombre,
            'categoria_id'     => $request->categoria_id,
            'principio_activo' => $request->principio_activo,
            'presentacion'     => $request->presentacion,
            'laboratorio'      => $request->laboratorio,
            'precio_unitario'  => $request->precio_unitario,
            'requiere_recipe'  => $request->has('requiere_recipe') ? true : false,
        ]);

        return redirect()->route('medicinas.index')
                         ->with('success', 'Medicina actualizada correctamente.');
    }

    /**
     * Remueve lógicamente o elimina la medicina del inventario.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $medicina = Medicina::findOrFail($id);
        $medicina->delete();

        return redirect()->route('medicinas.index')
                         ->with('success', 'Medicina eliminada del catálogo.');
    }
}