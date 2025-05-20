<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\PrestamoModelo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Consola;


class PrestamoControlador extends Controller
{
    public function index(){
        $prestamo = PrestamoModelo::all(); 
        if($prestamo->isEmpty()){
            $data=[
                'message'=>'No hay prestamos registrados',
                'status'=>200
            ];
            return response()->json($data,404);
        }
        return response()->json($prestamo,200);
    }
    
    public function store(Request $request){
    
        $validacion = Validator::make($request->all(), [
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'tiempodeuso' => 'required|integer|min:30', // Asegurar que sea un número y mínimo 30 minutos
            'reserva' => 'required',
            'id_cliente' => 'required|integer',
            'id_consola' => 'required|integer',
        ]);
        if ($validacion->fails()) {
            $data = [
                'message' => 'Error en la validación de datos',
                'error' => $validacion->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        // Verificar si la reserva es del dia actual o hasta MAX dos dias despues
        $fechaReserva = Carbon::parse($request->fecha);
        $hoy = Carbon::today();
        $maxFecha = $hoy->copy()->addDays(2);
        if ($fechaReserva->lt($hoy) || $fechaReserva->gt($maxFecha)) {
            return response()->json([
                'message' => 'Las reservas solo pueden realizarse desde hoy hasta un máximo de dos días después.',
                'status' => 422
            ], 422);
        }
        // Reservas entre las 10:00am hasta las 8:00pm
        $horaReserva = Carbon::createFromFormat('H:i', $request->hora);
        $inicioHorario = Carbon::createFromTime(10, 0);
        $finHorario = Carbon::createFromTime(20, 0);
        if ($horaReserva->lt($inicioHorario) || $horaReserva->gte($finHorario)) {
            return response()->json([
                'message' => 'Las reservas solo están permitidas entre las 10:00 am y las 8:00 pm.',
                'status' => 422
            ], 422);
        }
        
        // Reservas en intervalos de 30 minutos
        if ($horaReserva->minute % 30 !== 0) {
            return response()->json([
                'message' => 'Las reservas solo se pueden realizar en intervalos de 30 minutos.',
                'status' => 422
            ], 422);
        }

        // Validar que el cliente no tenga más de 2 reservas en el mismo día
        $reservasDelDia = PrestamoModelo::where('fecha', $request->fecha)
        ->where('id_cliente', $request->id_cliente)
        ->count();

        if ($reservasDelDia >= 2) {
        return response()->json([
            'message' => 'Solo puedes realizar un máximo de 2 reservas por día.',
            'status' => 422
        ], 422);
        }

        // Calcular la hora de finalización del nuevo préstamo
        $horaInicio = Carbon::createFromFormat('H:i', $request->hora);
        $horaFin = $horaInicio->copy()->addMinutes($request->tiempodeuso);
    
        // Verificar si hay conflictos con reservas existentes
        $conflicto = PrestamoModelo::where('fecha', $request->fecha)
        ->where('id_consola', $request->id_consola)
        ->where(function ($query) use ($horaInicio, $horaFin) {
            $query->where(function ($q) use ($horaInicio, $horaFin) {
                $q->where('hora', '<', $horaFin->format('H:i'))
                ->whereRaw('ADDTIME(hora, SEC_TO_TIME(tiempodeuso * 60)) > ?', [$horaInicio->format('H:i')]);
            });
        })
        ->exists();
        if ($conflicto) {
        return response()->json([
            'message' => 'La consola ya está reservada en ese horario',
            'status' => 422
        ], 422);
        }

        // 🔍 Verificar si la consola está disponible
        $consola = Consola::find($request->id_consola);
        if (!$consola || $consola->estado !== Consola::ESTADO_DISPONIBLE){
        return response()->json([
            'message' => 'La consola seleccionada no está disponible para reservas.',
            'status' => 422
        ], 422);
        }

        // Crear el préstamo si no hay conflictos
        $prestamo = PrestamoModelo::create([
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'tiempodeuso' => $request->tiempodeuso,
            'reserva' => $request->reserva,
            'id_cliente' => $request->id_cliente,
            'id_consola' => $request->id_consola,
        ]);
        if (!$prestamo) {
            $data = [
                'message' => 'Error al almacenar el préstamo',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
        $data = [
            'Prestamo' => $prestamo,
            'Status' => 201
        ];
        return response()->json($data, 201);
    }
    // Buscar Registro
    public function show($idPrestamo){
        $prestamo = PrestamoModelo::find($idPrestamo);
        if(!$prestamo){
            $data=[
                'messsage'=>'Prestamo No Existe',
                'status'=>404
            ];
            return response()->json($data,404);
        }
        $data=[
            'Prestamo'=>$prestamo,
            'Status'=>200
        ];
        return response()->json($data,200);
    }
    // Modificar Registro
    public function update(Request $request, $idPrestamo)
{
    // Buscar el préstamo por ID
    $prestamo = PrestamoModelo::find($idPrestamo);
    if (!$prestamo) {
        return response()->json([
            'message' => 'Préstamo no encontrado',
            'status' => 404
        ], 404);
    }
    // Validación de los datos
    $validacion = Validator::make($request->all(), [
        'fecha' => 'required|date',
        'hora' => 'required|date_format:H:i',
        'tiempodeuso' => 'required|integer|min:30', // Tiempo mínimo de 30 minutos

        'id_consola' => 'required|exists:consola,id'
    ]);
    if ($validacion->fails()) {
        return response()->json([
            'message' => 'Error en la validación de datos',
            'error' => $validacion->errors(),
            'status' => 400
        ], 400);
    }
    // Verificar si la reserva es del día actual o hasta dos días después
    $fechaReserva = Carbon::parse($request->fecha);
    $hoy = Carbon::today();
    $maxFecha = $hoy->copy()->addDays(2);
    if ($fechaReserva->lt($hoy) || $fechaReserva->gt($maxFecha)) {
        return response()->json([
            'message' => 'Las reservas solo pueden realizarse desde hoy hasta un máximo de dos días después.',
            'status' => 422
        ], 422);
    }
    // Reservas entre las 10:00 am hasta las 8:00 pm
    $horaReserva = Carbon::createFromFormat('H:i', $request->hora);
    $inicioHorario = Carbon::createFromTime(10, 0);
    $finHorario = Carbon::createFromTime(20, 0);
    if ($horaReserva->lt($inicioHorario) || $horaReserva->gte($finHorario)) {
        return response()->json([
            'message' => 'Las reservas solo están permitidas entre las 10:00 am y las 8:00 pm.',
            'status' => 422
        ], 422);
    }
    
    // Reservas en intervalos de 30 minutos
    if ($horaReserva->minute % 30 !== 0) {
        return response()->json([
            'message' => 'Las reservas solo se pueden realizar en intervalos de 30 minutos.',
            'status' => 422
        ], 422);
    }
    

    // Calcular la hora de finalización del nuevo préstamo
    $horaInicio = Carbon::createFromFormat('H:i', $request->hora);
    $horaFin = $horaInicio->copy()->addMinutes($request->tiempodeuso); // Usar minutos
    // Verificar si hay conflictos con reservas existentes (excluyendo el préstamo actual)
    $conflictos = PrestamoModelo::where('fecha', $request->fecha)
        ->where('id_consola', $request->id_consola)
        ->where('idPrestamo', '!=', $idPrestamo) // Excluir el préstamo actual
        ->get();
    foreach ($conflictos as $reserva) {
        $horaInicioExistente = Carbon::createFromFormat('H:i', $reserva->hora);
        $horaFinExistente = $horaInicioExistente->copy()->addMinutes($reserva->tiempodeuso); // Usar minutos
        // Verificar si hay solapamiento
        if ($horaInicio->lt($horaFinExistente) && $horaFin->gt($horaInicioExistente)) {
            return response()->json([
                'message' => 'La consola ya está reservada en ese horario.',
                'status' => 422
            ], 422);
        }
    }
    // Actualizar el préstamo
    $prestamo->fecha = $request->fecha;
    $prestamo->hora = $request->hora;
    $prestamo->tiempodeuso = $request->tiempodeuso;
    $prestamo->reserva = $request->reserva;
    $prestamo->id_cliente = $request->id_cliente;
    $prestamo->id_consola = $request->id_consola;
    $prestamo->save();
    return response()->json([
        'message' => 'Préstamo modificado correctamente',
        'prestamo' => $prestamo,
        'status' => 200
    ], 200);
}
    // Eliminar Registro
    public function destroy(Request $request, $idPrestamo)
    {
        $prestamo = PrestamoModelo::find($idPrestamo);

        if (!$prestamo) {
            $data = [
                'message' => 'Prestamo no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        // Verificamos si la fecha es futura
        $fechaReserva = Carbon::parse($prestamo->fecha);
        $hoy = Carbon::today();

        if ($fechaReserva->lt($hoy)) {
            $data = [
                'message' => 'No se puede eliminar esta reserva porque pertenece al historial.',
                'status' => 409
            ];
            return response()->json($data, 409);
        }

        // Eliminar la venta asociada usando DB::table
        DB::table('venta')->where('id_prestamo', $idPrestamo)->delete();

        // Eliminar el préstamo
        $prestamo->delete();

        $data = [
            'message' => 'Prestamo eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

}
