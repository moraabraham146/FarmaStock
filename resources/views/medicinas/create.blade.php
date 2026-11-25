@extends('layouts.base')

@section('title', 'Nueva medicina')

@section('content')
    <h1 class="h3 mb-3">Nueva medicina</h1>

    <form action="#" method="POST" class="card card-body shadow-sm">
        @csrf

        <div class="row g-3">
            <div class="col-md-4">
                <label for="codigo" class="form-label">Código</label>
                <input type="text" name="codigo" id="codigo" maxlength="50"
                       class="form-control @error('codigo') is-invalid @enderror"
                       value="{{ old('codigo') }}">
                @error('codigo') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-8">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" maxlength="150"
                       class="form-control @error('nombre') is-invalid @enderror"
                       value="{{ old('nombre') }}">
                @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="categoria_id" class="form-label">Categoría</label>
                <select name="categoria_id" id="categoria_id"
                        class="form-select @error('categoria_id') is-invalid @enderror">
                    <option value="">Seleccione...</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" @selected(old('categoria_id') == $categoria->id)>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('categoria_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="principio_activo" class="form-label">Principio activo</label>
                <input type="text" name="principio_activo" id="principio_activo" maxlength="150"
                       class="form-control" value="{{ old('principio_activo') }}">
            </div>

            <div class="col-md-6">
                <label for="presentacion" class="form-label">Presentación</label>
                <input type="text" name="presentacion" id="presentacion" maxlength="80"
                       class="form-control @error('presentacion') is-invalid @enderror"
                       value="{{ old('presentacion') }}">
                @error('presentacion') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="laboratorio" class="form-label">Laboratorio</label>
                <input type="text" name="laboratorio" id="laboratorio" maxlength="100"
                       class="form-control" value="{{ old('laboratorio') }}">
            </div>

            <div class="col-md-6">
                <label for="precio_unitario" class="form-label">Precio unitario</label>
                <input type="number" step="0.01" min="0" name="precio_unitario" id="precio_unitario"
                       class="form-control @error('precio_unitario') is-invalid @enderror"
                       value="{{ old('precio_unitario', '0.00') }}">
                @error('precio_unitario') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="stock_minimo" class="form-label">Stock mínimo</label>
                <input type="number" min="0" name="stock_minimo" id="stock_minimo"
                       class="form-control @error('stock_minimo') is-invalid @enderror"
                       value="{{ old('stock_minimo', 5) }}">
                @error('stock_minimo') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <input type="hidden" name="requiere_recipe" value="0">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="requiere_recipe"
                           id="requiere_recipe" value="1" @checked(old('requiere_recipe'))>
                    <label class="form-check-label" for="requiere_recipe">Requiere récipe médico</label>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="#" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
@endsection