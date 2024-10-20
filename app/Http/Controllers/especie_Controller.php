<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\especie_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class especie_Controller extends Controller
{
    public function index(Request $request){
        $validate = Validator::make(
            $request-> all(),[
        'nombre'=>'required|string|max:20',
        'nombre_cientifico'=>'required|string|max:200',
        'estado_de_conservacion'=>'required|string|max:100',
            ]);
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validate->errors(),
            ], 400); // Devuelve un error 400 si la validación falla.
        }
        $validate = especie_Model::create($request->all());
        return response()->json([
            'success' => true,
            'data' => $validate,   
        ], 201);
    }
    // Actualizar un especie por ID
        public function update(Request $request, $id)
        {
            $especie = especie_Model::find($id);
    
            if (!$especie) {
                return response()->json([
                    'success' => false,
                    'message' => 'especie no encontrada',
                ], 404);
            }
    
            // Validaciones
            $especie = Validator::make($request->all(), [
        'nombre'=>'required|string|max:20',
        'nombre_cientifico'=>'required|string|max:200',
        'estado_de_conservacion'=>'required|string|max:100',
            ]);
    
            if ($especie->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $especie->errors(),
                ], 400);
            }
    
            // Actualizar el especie
            $especie->update($request->all());
    
            return response()->json([
                'success' => true,
                'data' => $especie,
            ]);
        }
    
        // Eliminar un especie por ID
        public function destroy($id)
        {
            $especie = especie_Model::find($id);
    
            if (!$especie) {
                return response()->json([
                    'success' => false,
                    'message' => 'especie no encontrado',
                ], 404);
            }
    
            $especie->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'especie eliminada correctamente',
            ]);
        }
        public function restore($id)
        {
            $especie = especie_Model::onlyTrashed()->where('id', $id)->first();
    
            if (!$especie) {
                return response()->json(['message' => 'especie no encontrada o no eliminada'], 404);
            }
    
            // Restaurar el especie
            $especie->restore();
            return response()->json(['message' => 'especie restaurada']);
        }
        public function show($id)
    {
        // Buscar al especie por ID
        $especie = especie_Model::find($id);

        // Verificar si el animal existe
        if (!$especie)
        {
            return response()->json([
                'msg' => 'No se encontró el animal'
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

            // Paso 3: Devolver la respuesta al cliente con los datos del especie y la API
            return response()->json([
                'msg' => 'dieta encontrada',
                '------'=>'-------',
                'dieta' => $especie,
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
