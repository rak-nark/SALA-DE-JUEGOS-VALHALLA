<?php

use App\Http\Controllers\prestamoControlador;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MisprestamosController;
use App\Http\Controllers\ReservaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Rutas públicas (sin autenticación)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas (requieren autenticación)
Route::middleware('auth:sanctum')->group(function () {
    // Rutas relacionadas con el cliente
    Route::put('/cliente/{idCliente}', [AuthController::class, 'update']);
    Route::get('/cliente', [AuthController::class, 'index']);
    Route::delete('/cliente/{idCliente}', [AuthController::class, 'destroy']);


    // Rutas relacionadas con las reservas
    Route::get('/prestamos', [ReservaController::class, 'index']); // Obtener todos los préstamos
    Route::get('/reserva', [prestamoControlador::class, 'index']); // Obtener todas las reservas
    Route::post('/reserva', [prestamoControlador::class, 'store']); // Crear una reserva
    Route::get('/reserva/{idPrestamo}', [prestamoControlador::class, 'show']); // Obtener una reserva específica
    Route::put('/reserva/{idPrestamo}', [prestamoControlador::class, 'update']); // Actualizar una reserva
    Route::delete('/reserva/{idPrestamo}', [prestamoControlador::class, 'destroy']); // Eliminar una reserva

    // Ruta para obtener las reservas del usuario autenticado
    Route::get('/mis-reservas', [ReservaController::class, 'misReservas']);

    // Ruta para cerrar sesión
    Route::get('/logout', [AuthController::class, 'logout']);
});

// Ruta para obtener préstamos de un cliente específico
Route::get('prestamos/{clienteId}', [MisprestamosController::class, 'obtenerPrestamos']);