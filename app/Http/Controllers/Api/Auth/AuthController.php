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
 * Class AuthController.
 *
 * @author  Moises Bumba <moises-alberto@hotmail.com>
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth",
     *     tags={"Authenticated"},
     *     summary="Authenticate user",
     *     description="Authenticates a user based on the provided credentials.",
     *     operationId="auth",
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

        $user->tokens()->delete();
        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'token' => $token
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/getAuthenticatedUser",
     *     tags={"Authenticated"},
     *     summary="Get authenticated user data",
     *     description="Returns the data of the currently authenticated user.",
     *     operationId="getAuthenticatedUser",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Authenticated user data",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Moises Bumba"),
     *             @OA\Property(property="email", type="string", example="moises.bumba@example.com"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Not authorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         ),
     *     ),
     * )
     */

    public function me()
    {
        $user = auth()->user();
        return new UserResource($user);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     tags={"Authenticated"},
     *     summary="User Logout",
     *     description="Revokes all tokens from the authenticated user, effectively logging out.",
     *     operationId="logout",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful logout",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true)
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Not authorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         ),
     *     ),
     * )
     */

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json((['success' => true]));
    }
}
