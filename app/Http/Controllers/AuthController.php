<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use OpenApi\Annotations as OA;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     * path="/auth/token",
     * summary="Sign in",
     * description="Login by email and password",
     * operationId="authLogin",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="test@example.com"),
     *       @OA\Property(property="password", type="string", format="password", example="password"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Ok",
     *    @OA\JsonContent(
     *       @OA\Property(property="email", type="string", example="test@example.com"),
     *       @OA\Property(property="access_token", type="string", example="bccddf99-6447-4a18-82a3-720551a4a28a|2ywiuSDEvdFzXFHicDeHV468DVt5Vcljjq8acOTr"),
     *        )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::query()
            ->where('email', $request->email)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($user->id);

        return response()->json(['email' => $user->email, 'access_token' => $token->plainTextToken]);
    }

    /**
     * @OA\Get(
     * path="/auth/me",
     * summary="Get Me",
     * description="Get User",
     * operationId="authMe",
     * tags={"Auth"},
     * security={{"sanctum":{}}},
     * @OA\Response(
     *    response=200,
     *    description="Ok",
     *    @OA\JsonContent(
     *       @OA\Property(property="id", type="string", example="bccddf99-6447-4a18-82a3-720551a4a28a"),
     *       @OA\Property(property="name", type="string", example="Test User"),
     *       @OA\Property(property="email", type="string", example="test@example.com"),
     *       @OA\Property(property="email_verified_at", type="string", example="2023-05-19 18:59:18"),
     *       @OA\Property(property="created_at", type="string", example="2023-05-19 18:59:18"),
     *       @OA\Property(property="updated_at", type="string", example="2023-05-19 18:59:18"),
     *        )
     *     )
     * )
     */
    public function show(Request $request)
    {
        return response()->json($request->user());
    }
}
