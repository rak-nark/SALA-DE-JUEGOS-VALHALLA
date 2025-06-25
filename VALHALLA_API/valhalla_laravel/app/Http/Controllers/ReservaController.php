<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\PrestamoModelo;
use Illuminate\Support\Facades\Auth;
class ReservaController extends Controller
{
    public function misReservas()
    {
        // Obtener el ID del cliente autenticado
        $idCliente = Auth::id();
        if (!$idCliente) {
            return response()->json([
                'error' => 'Usuario no autenticado.',
                'status' => 401
            ], 401);
        }
        // Obtener las reservas asociadas al cliente autenticado
        $reservas = PrestamoModelo::where('id_cliente', $idCliente)->get();
        return response()->json($reservas, 200);
    }
}