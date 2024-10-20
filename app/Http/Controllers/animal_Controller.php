<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\animal_Model;
use Illuminate\Support\Facades\Http;
class animal_Controller extends Controller
{
    public function index(Request $request){
        $validate = Validator::make(
            $request-> all(),[
        'nombre'=>'required|string|max:20',
        'edad' => 'required|integer',
        'genero' => 'required|in:M,H',
        'id_de_especie'=>'required|integer|min:1',
        'id_habitat'=>'required|integer|min:1',
            ]
        );
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validate->errors(),
            ], 400); // Devuelve un error 400 si la validación falla.
        }
        $validate = animal_Model::create($request->all());
        return response()->json([
            'success' => true,
            'data' => $validate,   
        ], 201);
    }
    // Actualizar un animal por ID
        public function update(Request $request, $id)
        {
            $animal = animal_Model::find($id);
    
            if (!$animal) {
                return response()->json([
                    'success' => false,
                    'message' => 'Animal no encontrado',
                ], 404);
            }
    
            // Validaciones
            $validator = Validator::make($request->all(), [
                'nombre' => 'sometimes|required|string|max:255',
                'especie' => 'sometimes|required|string|max:255',
                'edad' => 'sometimes|required|integer|min:0',
                'genero' => 'sometimes|required|in:M,H',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 400);
            }
    
            // Actualizar el animal
            $animal->update($request->all());
    
            return response()->json([
                'success' => true,
                'data' => $animal,
            ]);
        }
    
        // Eliminar un animal por ID
        public function destroy($id)
        {
            $animal = animal_Model::find($id);
    
            if (!$animal) {
                return response()->json([
                    'success' => false,
                    'message' => 'Animal no encontrado',
                ], 404);
            }
    
            $animal->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Animal eliminado correctamente',
            ]);
        }
        public function restore($id)
        {
            $animal = animal_Model::onlyTrashed()->where('id', $id)->first();
    
            if (!$animal) {
                return response()->json(['message' => 'animal no encontrada o no eliminada'], 404);
            }
    
            // Restaurar el animal
            $animal->restore();
            return response()->json(['message' => 'animal restaurada']);
        }
        public function show($id)
    {
        // Buscar al animal por ID
        $animal = animal_Model::find($id);

        // Verificar si el animal existe
        if (!$animal)
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

            // Paso 3: Devolver la respuesta al cliente con los datos del animal y la API
            return response()->json([
                'msg' => 'animal encontrado',
                '------'=>'-------',
                'animal' => $animal,
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
    

