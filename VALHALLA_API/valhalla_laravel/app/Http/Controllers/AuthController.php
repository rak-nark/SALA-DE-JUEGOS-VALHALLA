<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\clienteModelo;
use \stdClass;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class AuthController extends Controller
{ 
    public function index(){
        $cliente = clienteModelo::all();
        if($cliente->isEmpty()){
            $data=[
                'message'=>'No hay clientes registrados',
                'status'=>200
            ];
            return response()->json($data,404);
        }
        return response()->json($cliente,200);
    }
    public function register(Request $request)
    {
        $messages = [
            'nombreCliente.required' => 'El nombre es obligatorio.',
            'nombreCliente.min' => 'El nombre debe tener al menos 2 caracteres.',
            'apellidoCliente.required' => 'El apellido es obligatorio.',
            'apellidoCliente.min' => 'El apellido debe tener al menos 2 caracteres.',
            'correoCliente.required' => 'El correo es obligatorio.',
            'correoCliente.email' => 'El correo debe ser una dirección válida.',
            'contrasenaCliente.required' => 'La contraseña es obligatoria.',
            'contrasenaCliente.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ];
    
        $validator = Validator::make($request->all(), [
            'nombreCliente' => 'required|min:2|max:40',
            'apellidoCliente' => 'required|min:2|max:40',
            'correoCliente' => 'required|email',
            'contrasenaCliente' => 'required|string|min:8|max:40'
        ], $messages);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        $cliente = clienteModelo::create([
            'nombreCliente' => $request->nombreCliente,
            'apellidoCliente' => $request->apellidoCliente,
            'correoCliente' => $request->correoCliente,
            'contrasenaCliente' => Hash::make($request->contrasenaCliente)
        ]);
    
        $token = $cliente->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'data' => $cliente,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 201);
    }
    
    public function destroy($idCliente)
{
    $cliente = clienteModelo::find($idCliente);
    if (!$cliente) {
        return response()->json(['message' => 'Cliente no encontrado'], 404);
    }
    // 🔹 Eliminar primero las reservas y préstamos del cliente
    
    DB::table('prestamo')->where('id_cliente', $idCliente)->delete();
    // 🔹 Ahora sí, eliminar el cliente
    $cliente->delete();
    return response()->json(['message' => 'Cliente y registros asociados eliminados correctamente'], 200);
}
    
    
    public function login(Request $request)
{
    // Validar los datos de entrada
    $validacion = Validator::make($request->all(), [
        'correoCliente' => 'required|email',
        'contrasenaCliente' => 'required|min:5|max:20'
    ]);
    // Si la validación falla, devolver un error
    if ($validacion->fails()) {
        return response()->json([
            'message' => 'Error en la validación de datos',
            'errors' => $validacion->errors(),
            'status' => 400
        ], 400);
    }
    // Buscar el cliente por correo electrónico
    $cliente = ClienteModelo::where('correoCliente', $request->correoCliente)->first();
    // Si el cliente no existe, devolver un error
    if (!$cliente) {
        return response()->json([
            'message' => 'Correo electrónico no encontrado',
            'status' => 404
        ], 404);
    }
    // Verificar la contraseña
    if (!Hash::check($request->contrasenaCliente, $cliente->contrasenaCliente)) {
        return response()->json([
            'message' => 'Contraseña incorrecta',
            'status' => 401
        ], 401);
    }
    // Generar el token de autenticación
    $token = $cliente->createToken('nombre-del-token')->plainTextToken;
    // Devolver la respuesta JSON con el token y el idCliente
    return response()->json([
        'cliente' => [
            'idCliente' => $cliente->idCliente, // 🔹 Incluir el idCliente
            'nombreCliente' => $cliente->nombreCliente,
            'correoCliente' => $cliente->correoCliente
        ],
        'token' => $token,
        'status' => 200
    ], 200);
}
public function update(Request $request, $id)
{
    $messages = [
        'nombreCliente.min' => 'El nombre debe tener al menos 2 caracteres.',
        'apellidoCliente.min' => 'El apellido debe tener al menos 2 caracteres.',
        'correoCliente.email' => 'El correo debe ser una dirección válida.',
        'contrasenaCliente.min' => 'La contraseña debe tener al menos 8 caracteres.',
    ];
    $validator = Validator::make($request->all(), [
        'nombreCliente' => 'sometimes|min:2|max:40', // No es obligatorio
        'apellidoCliente' => 'sometimes|min:2|max:40', // No es obligatorio
        'correoCliente' => 'sometimes|email', // No es obligatorio
        'contrasenaCliente' => 'sometimes|string|min:8|max:40' // No es obligatorio
    ], $messages);
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }
    // Buscar el cliente por ID
    $cliente = clienteModelo::find($id);
    if (!$cliente) {
        return response()->json(['message' => 'Cliente no encontrado'], 404);
    }
    // Actualizar solo los campos proporcionados
    if ($request->has('nombreCliente')) {
        $cliente->nombreCliente = $request->nombreCliente;
    }
    if ($request->has('apellidoCliente')) {
        $cliente->apellidoCliente = $request->apellidoCliente;
    }
    if ($request->has('correoCliente')) {
        $cliente->correoCliente = $request->correoCliente;
    }
    if ($request->has('contrasenaCliente')) {
        $cliente->contrasenaCliente = Hash::make($request->contrasenaCliente);
    }
    $cliente->save();
    return response()->json([
        'data' => $cliente,
        'message' => 'Cliente actualizado correctamente'
    ], 200);
}
    public function logout(Request $request)
    {
        Auth()->user()->tokens()->delete();
        return [
            response()->json(['message' => 'Logged out successfully'], 200)
        ];
    }
}
