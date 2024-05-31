<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * Class User.
 *
 * @author  Moises Bumba <moises-alberto@hotmail.com>
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth",
     *     tags={"Autenticação"},
     *     summary="Autenticar usuário",
     *     description="Autentica um usuário com base nas credenciais fornecidas.",
     *     operationId="authenticateUser",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados de autenticação",
     *         @OA\JsonContent(
     *             required={"email", "password", "device_name"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="device_name", type="string", example="Mobile Device"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Autenticação bem-sucedida",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="token_value"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Credenciais inválidas",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="As credenciais fornecidas estão incorretas."),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="email", type="array",
     *                     @OA\Items(type="string", example="As credenciais fornecidas estão incorretas.")
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     */
    public function auth(AuthRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais fornecidas estão incorretas.'],
            ]);
        }

        //if ($request->has('Logout_others_devices')) $user->tokens()->delete();
        $user->tokens()->delete();
        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'token' => $token
        ]);

    }

    public function me()
    {
        $user = auth()->user();
        return new UserResource($user);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json((['success' => true]));
    }
}
