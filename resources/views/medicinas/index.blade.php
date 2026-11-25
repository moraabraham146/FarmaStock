@extends('layouts.base')

@section('title', 'Medicinas')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Medicinas</h1>
        <a href="#" class="btn btn-primary">+ Nueva medicina</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Presentación</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($medicinas as $medicina)
                        <tr>
                            <td>{{ $medicina->codigo }}</td>
                            <td>
                                {{ $medicina->nombre }}
                                @if ($medicina->requiere_recipe)
                                    <span class="badge bg-primary">Récipe</span>
                                @endif
                            </td>
                            <td>{{ $medicina->categoria->nombre }}</td>
                            <td>{{ $medicina->presentacion }}</td>
                            <td>${{ number_format($medicina->precio_unitario, 2) }}</td>
                            <td>
                                {{ $medicina->stock_total }}
                                @if ($medicina->stock_total < $medicina->stock_minimo)
                                    <span class="badge bg-warning text-dark">Stock bajo</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="#" class="btn btn-sm btn-secondary">Ver</a>
                                <a href="#" class="btn btn-sm btn-secondary">Editar</a>
                                <a href="#" class="btn btn-sm btn-secondary">Eliminar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No hay medicinas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection