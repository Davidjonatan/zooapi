<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\empleado_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class empleado_Controller extends Controller
{
    public function index(Request $request){
        $validate = Validator::make(
            $request-> all(),[
        'nombre'=>'required|string|max:20',
        'anios_de_experiencia'=>'required|integer|min:2',
            ]
        );
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validate->errors(),
            ], 400); // Devuelve un error 400 si la validación falla.
        }
        $empleado = empleado_Model::create($request->all());
        return response()->json([
            'success' => true,
            'data' => $empleado,   
        ], 201);
    }
    // Actualizar un empleado por ID
        public function update(Request $request, $id)
        {
            $empleado = empleado_Model::find($id);
    
            if (!$empleado) {
                return response()->json([
                    'success' => false,
                    'message' => 'empleado no encontrada',
                ], 404);
            }
    
            // Validaciones
            $validator = Validator::make($request->all(), [
              'nombre'=>'required|string|max:20',
        'anios_de_experiencia'=>'required|min:2',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 400);
            }
    
            // Actualizar el empleado
            $empleado->update($request->all());
    
            return response()->json([
                'success' => true,
                'data' => $empleado,
            ]);
        }
    
        // Eliminar un empleado por ID
        public function destroy($id)
        {
            $empleado = empleado_Model::find($id);
    
            if (!$empleado) {
                return response()->json([
                    'success' => false,
                    'message' => 'empleado no encontrado',
                ], 404);
            }
    
            $empleado->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'empleado eliminado correctamente',
            ]);
        }
        public function restore($id)
        {
            $empleado = empleado_Model::onlyTrashed()->where('id', $id)->first();
    
            if (!$empleado) {
                return response()->json(['message' => 'empleado no encontrada o no eliminado'], 404);
            }
    
            // Restaurar el empleado
            $empleado->restore();
            return response()->json(['message' => 'empleado restaurado']);
        }
        public function show($id)
    {
        // Buscar al empleado por ID
        $empleado = empleado_Model::find($id);

        // Verificar si el empleadov existe
        if (!$empleado)
        {
            return response()->json([
                'msg' => 'No se encontró el empleado'
            ], 404); // Código 404 para "No encontrado"
        }

        try 
        {
            // Paso 1: Hacer la solicitud POST para obtener el token desde la API externa
            $tokenResponse = Http::post('http://192.168.127.1:60501/login', [
                "email" => "Michele_Collins97@yahoo.com",
                "password" => "123456"
            ]);

            // Verificar si la solicitud para el token fue exitosa
            if ($tokenResponse->failed()) 
            {
                return response()->json([
                    'error' => 'Error al autenticar con la API externa'
                ], 400); // Código 400 para errores de autenticación
            }

            // Extraer el token de la respuesta
            $token = $tokenResponse->json('token');

            // Paso 2: Usar ese token para hacer otra solicitud GET a la API protegida
            $dataResponse = Http::withHeaders([
                'Authorization' => "Bearer {$token}"
            ])->get('http://192.168.127.1:60501/artistas');

            // Verificar si la solicitud de datos fue exitosa
            if ($dataResponse->failed()) {
                return response()->json([
                    'error' => 'Error al obtener datos de la API externa'
                ], 400); // Código 400 para errores de la API externa
            }

            // Paso 3: Devolver la respuesta al cliente con los datos del empleado y la API
            return response()->json([
                'msg' => 'dieta encontrada',
                '------'=>'-------',
                'empleado' => $empleado,
                'data' => $dataResponse->json()
            ], 200); // Código 200 para indicar éxito
        } catch (\Exception $e) {
            // Manejo de errores generales
            return response()->json([
                'error' => 'Error al comunicarse con la API externa'
            ], 500); // Código 500 para errores de servidor
        }
    }
}
