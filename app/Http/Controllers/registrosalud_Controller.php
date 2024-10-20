<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\registro_salud_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class registrosalud_Controller extends Controller
{
    public function index(Request $request){
        $validate = Validator::make(
            $request-> all(),[
                'id_animal'=>'required|integer|exists:animales,id',
                'fecha_de_revision'=>'required|date',
                'estado_de_salud'=>'required|string|max:255',
            ]
        );
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validate->errors(),
            ], 400); // Devuelve un error 400 si la validación falla.
        }
        $registro = registro_salud_Model::create($request->all());
        return response()->json([
            'success' => true,
            'data' => $registro,   
        ], 201);
    }
    // Actualizar un registro por ID
        public function update(Request $request, $id)
        {
            $registro = registro_salud_Model::find($id);
    
            if (!$registro) {
                return response()->json([
                    'success' => false,
                    'message' => 'registro no encontrada',
                ], 404);
            }
    
            // Validaciones
            $validator = Validator::make($request->all(), [
                'id_animal'=>'required|integer|exists:animales,id',
                'fecha_de_revision'=>'required|date',
                'estado_de_salud'=>'required|string|max:255',
            
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 400);
            }
    
            // Actualizar el registro
            $registro->update($request->all());
    
            return response()->json([
                'success' => true,
                'data' => $registro,
            ]);
        }
    
        // Eliminar un registro por ID
        public function destroy($id)
        {
            $registro = registro_salud_Model::find($id);
    
            if (!$registro) {
                return response()->json([
                    'success' => false,
                    'message' => 'registro no encontrado',
                ], 404);
            }
    
            $registro->delete();
            return response()->json([
                'success' => true,
                'message' => 'registro eliminado correctamente',
            ]);
        }
        public function restore($id)
        {
            $registro = registro_salud_Model::onlyTrashed()->where('id', $id)->first();
    
            if (!$registro) {
                return response()->json(['message' => 'registro no encontrado o no eliminado'], 404);
            }
    
            // Restaurar el registro
            $registro->restore();
            return response()->json(['message' => 'registro restaurado']);
        }
        public function show($id)
    {
        // Buscar al registro por ID
        $registro = registro_salud_Model::find($id);

        // Verificar si el registro existe
        if (!$registro)
        {
            return response()->json([
                'msg' => 'No se encontró el registro'
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

            // Paso 3: Devolver la respuesta al cliente con los datos del registro y la API
            return response()->json([
                'msg' => 'registro encontrada',
                '------'=>'-------',
                'registro' => $registro,
                'registro' => $dataResponse->json()
            ], 200); // Código 200 para indicar éxito
        } catch (\Exception $e) {
            // Manejo de errores generales
            return response()->json([
                'error' => 'Error al comunicarse con la API externa'
            ], 500); // Código 500 para errores de servidor
        }
    }
}
