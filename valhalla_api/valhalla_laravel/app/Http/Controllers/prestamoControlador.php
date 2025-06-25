<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\models\prestamoModelo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
class prestamoControlador extends Controller
{


    public function index(){
        $prestamo = prestamoModelo::all(); 
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
            'tiempodeuso' => 'required|string',
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
        // Calcular la hora de finalización del nuevo préstamo
        $horaInicio = Carbon::createFromFormat('H:i', $request->hora);
        $horaFin = $horaInicio->copy()->addHours($request->tiempodeuso);
        // Verificar si hay conflictos con reservas existentes
        $conflicto = prestamoModelo::where('fecha', $request->fecha)
            ->where('id_consola', $request->id_consola)
            ->where(function ($query) use ($request, $horaInicio, $horaFin) {
                $query->whereBetween('hora', [$horaInicio->format('H:i'), $horaFin->format('H:i')])
                    ->orWhereRaw('? BETWEEN hora AND ADDTIME(hora, SEC_TO_TIME(?))', [
                        $horaInicio->format('H:i'),
                        $request->tiempodeuso * 3600
                    ]);
            })
            ->exists();
        if ($conflicto) {
            $data = [
                'message' => 'La consola ya está reservada en ese horario',
                'status' => 422
            ];
            return response()->json($data, 422);
        }
        // Crear el préstamo si no hay conflictos
        $prestamo = prestamoModelo::create([
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
        $prestamo = prestamoModelo::find($idPrestamo);
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
    public function update (Request $request, $idPrestamo){
        $prestamo=prestamoModelo::find($idPrestamo);
        if(!$prestamo) {
            $data=[
                'message'=>'Prestamo no encontrado',
                'status'=>404
            ];
            return response()->json($data,404);
        }
        $validacion=Validator::make($request->all(), 
        [
            'fecha'=>'Required|min:2|max:40',
            'hora'=>'Required|min:2|max:40',
            'tiempodeuso'=>'Required',
            'reserva'=>'Required',
            'id_cliente'=>'Required',
            'id_consola'=>'Required'
        ]);
        if($validacion->fails()){
            $data=[
                'messsage'=>'Error en la validacion de datos',
                'error'=>$validacion->errors(),
                'status'=>200
            ];
            return response()->json($data,400);
        };
        // Calcular la hora de finalización del nuevo préstamo
        $horaInicio = Carbon::createFromFormat('H:i', $request->hora);
        $horaFin = $horaInicio->copy()->addHours($request->tiempodeuso);
        // Verificar si hay conflictos con reservas existentes
        $conflicto = prestamoModelo::where('fecha', $request->fecha)
            ->where('id_consola', $request->id_consola)
            ->where(function ($query) use ($request, $horaInicio, $horaFin) {
                $query->whereBetween('hora', [$horaInicio->format('H:i'), $horaFin->format('H:i')])
                    ->orWhereRaw('? BETWEEN hora AND ADDTIME(hora, SEC_TO_TIME(?))', [
                        $horaInicio->format('H:i'),
                        $request->tiempodeuso * 3600
                    ]);
            })
            ->exists();
        if ($conflicto) {
            $data = [
                'message' => 'La consola ya está reservada en ese horario',
                'status' => 422
            ];
            return response()->json($data, 422);
        }
            $prestamo->fecha=$request->fecha;
            $prestamo->hora=$request->hora;
            $prestamo->tiempodeuso=$request->tiempodeuso;
            $prestamo->reserva=$request->reserva;
            $prestamo->id_cliente=$request->id_cliente;
            $prestamo->id_consola=$request->id_consola;
            $prestamo->save();
        $data=[
                'messsage'=>'Prestamo modificado',
                'cliente'=>$prestamo,
                'status'=>200
            ];
            return response()->json($data,200);
    }
    // Eliminar Registro
    public function destroy (Request $request, $idPrestamo){
        $prestamo = prestamoModelo::find($idPrestamo);
        if(!$prestamo) {
            $data=[
                'message'=>'Prestamo no encontrado',
                'status'=>404
            ];
            return response()->json($data,404);
        } else {
            $prestamo->delete();
            $data=[
                'message'=>'Prestamo eliminado',
                'status'=>200
            ];
            return response()->json($data,200);
        }
    }
}
