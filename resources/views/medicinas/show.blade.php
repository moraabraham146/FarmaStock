@extends('layouts.base')

@section('title', $medicina->nombre)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">{{ $medicina->nombre }}</h1>
        <div>
            <a href="{{ route('medicinas.edit', $medicina->id) }}" class="btn btn-warning">Editar</a>
            <a href="{{ route('medicinas.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <div class="card card-body shadow-sm mb-4">
        <dl class="row mb-0">
            <dt class="col-sm-3">Código</dt>
            <dd class="col-sm-9">{{ $medicina->codigo }}</dd>

            <dt class="col-sm-3">Categoría</dt>
            <dd class="col-sm-9">{{ $medicina->categoria->nombre }}</dd>

            <dt class="col-sm-3">Principio activo</dt>
            <dd class="col-sm-9">{{ $medicina->principio_activo ?? '—' }}</dd>

            <dt class="col-sm-3">Presentación</dt>
            <dd class="col-sm-9">{{ $medicina->presentacion }}</dd>

            <dt class="col-sm-3">Laboratorio</dt>
            <dd class="col-sm-9">{{ $medicina->laboratorio ?? '—' }}</dd>

            <dt class="col-sm-3">Precio unitario</dt>
            <dd class="col-sm-9">${{ number_format($medicina->precio_unitario, 2) }}</dd>

            <dt class="col-sm-3">Stock</dt>
            <dd class="col-sm-9">
                {{ $medicina->stock_total }} (mínimo: {{ $medicina->stock_minimo }})
                @if ($medicina->stock_total < $medicina->stock_minimo)
                    <span class="badge bg-danger">Stock bajo</span>
                @endif
            </dd>

            <dt class="col-sm-3">Requiere récipe</dt>
            <dd class="col-sm-9">{{ $medicina->requiere_recipe ? 'Sí' : 'No' }}</dd>
        </dl>
    </div>

    <h2 class="h5 bg-white bg-opacity-75 rounded p-2 d-inline-block">Lotes</h2>
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>N.º de lote</th>
                        <th>Vencimiento</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($medicina->lotes as $lote)
                        @php $vence = \Carbon\Carbon::parse($lote->fecha_vencimiento); @endphp
                        <tr>
                            <td>{{ $lote->numero_lote }}</td>
                            <td>
                                {{ $vence->format('d/m/Y') }}
                                @if ($vence->isPast())
                                    <span class="badge bg-danger">Vencido</span>
                                @elseif ($vence->lte(now()->addDays(60)))
                                    <span class="badge bg-warning text-dark">Por vencer</span>
                                @endif
                            </td>
                            <td>{{ $lote->cantidad_actual }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-3">Sin lotes registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection