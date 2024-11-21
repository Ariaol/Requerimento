<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MoodleController extends Controller
{
    public function authenticate(Request $request)
    {
        // Enviar a requisição ao endpoint do Moodle para autenticar
        $response = Http::get('http://localhost/moodle/login/token.php', [
            'username' => $request->username,
            'password' => $request->password,
            'service'  => 'api',
        ]);
    
        // Verificar se a resposta foi bem-sucedida
        if ($response->successful()) {
            $data = $response->json();
    
            if (isset($data['token'])) {
                $moodleToken = $data['token'];
    
                // Consultar os dados do usuário no Moodle usando o token gerado
                $userDataResponse = Http::get('http://localhost/moodle/webservice/rest/server.php', [
                    'wstoken' => $moodleToken,
                    'wsfunction' => 'core_user_get_users',
                    'moodlewsrestformat' => 'json',
                    'criteria[0][key]' => 'username',
                    'criteria[0][value]' => $request->username,
                ]);
    
                // Verificar se os dados adicionais foram obtidos com sucesso
                if ($userDataResponse->successful()) {
                    $userData = $userDataResponse->json();
    
                    // Criar e retornar uma resposta com os dados do Moodle
                    return redirect()->route('menu')->with([
                        'status' => 'success',
                        'user' => $userData['users'][0] ?? [],
                    ]);
                }
    
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to fetch user data from Moodle',
                ], 500);
            }
    
            // Erro retornado pelo Moodle
            return response()->json([
                'status'  => 'error',
                'message' => $data['error'] ?? 'Invalid credentials',
            ], 401);
        }
    
        // Falha ao conectar ao Moodle
        return response()->json([
            'status'  => 'error',
            'message' => 'Failed to connect to Moodle',
        ], 500);
    }
}