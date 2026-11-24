<?php

use App\Http\Controllers\MedicinaController;

/*
|--------------------------------------------------------------------------
| Rutas Web - FarmaStock
|--------------------------------------------------------------------------
| Registro de endpoints operacionales para el sistema de inventario farmacéutico.
*/

Route::resource('medicinas', MedicinaController::class);