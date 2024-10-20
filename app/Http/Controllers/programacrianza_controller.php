<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\programa_de_crianza_Model;
use Illuminate\Support\Facades\Http;
class programacrianza_controller extends Controller
{
    public function index(Request $request){
        $validate = Validator::make(
            $request-> all(),[
            'nombre'=>'string|required|max:100',
            'fecha_de_inicio'=>'required|date',
            'fecha_de_finalizacion'=>'required|date',
            ]
        );
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validate->errors(),
            ], 400); // Devuelve un error 400 si la validación falla.
        }
        $validate = programa_de_crianza_Model::create($request->all());
        return response()->json([
            'success' => true,
            'data' => $validate,   
        ], 201);
    }
    // Actualizar un animal por ID
        public function update(Request $request, $id)
        {
            $crianza = programa_de_crianza_Model::find($id);
    
            if (!$crianza) {
                return response()->json([
                    'success' => false,
                    'message' => 'crianza no encontrado',
                ], 404);
            }
    
            // Validaciones
            $validator = Validator::make($request->all(), [
            'nombre'=>'string|required|max:100',
            'fecha_de_inicio'=>'required|date',
            'fecha_de_finalizacion'=>'required|date',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 400);
            }
    
            // Actualizar el crianza
            $crianza->update($request->all());
    
            return response()->json([
                'success' => true,
                'data' => $crianza,
            ]);
        }
    
        // Eliminar un crianza por ID
        public function destroy($id)
        {
            $crianza = programa_de_crianza_Model::find($id);
    
            if (!$crianza) {
                return response()->json([
                    'success' => false,
                    'message' => 'crianza no encontrado',
                ], 404);
            }
    
            $crianza->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'crianza eliminado correctamente',
            ]);
        }
        public function restore($id)
        {
            $crianza = programa_de_crianza_Model::onlyTrashed()->where('id', $id)->first();
    
            if (!$crianza) {
                return response()->json(['message' => 'crianza no encontrada o no eliminada'], 404);
            }
    
            // Restaurar el crianza
            $crianza->restore();
            return response()->json(['message' => 'crianza restaurada']);
        }
        public function show($id)
    {
        // Buscar al animal por ID
        $crianza = programa_de_crianza_Model::find($id);

        // Verificar si el crianza existe
        if (!$crianza)
        {
            return response()->json([
                'msg' => 'No se encontró la crianza'
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

            // Paso 3: Devolver la respuesta al cliente con los datos del crianza y la API
            return response()->json([
                'msg' => 'animal encontrado',
                '------'=>'-------',
                'crianza' => $crianza,
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
