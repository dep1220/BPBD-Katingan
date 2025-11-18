<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/auth/login",
     *     tags={"Authentication"},
     *     summary="Login Admin",
     *     description="Login untuk mendapatkan token autentikasi",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="admin@bpbd.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login berhasil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Login berhasil"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="token", type="string", example="1|laravel_sanctum_token..."),
     *                 @OA\Property(property="token_type", type="string", example="Bearer"),
     *                 @OA\Property(
     *                     property="user",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Admin BPBD"),
     *                     @OA\Property(property="email", type="string", example="admin@bpbd.com"),
     *                     @OA\Property(property="created_at", type="string", format="date-time")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Kredensial tidak valid",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Email atau password salah")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation error"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(property="email", type="array", @OA\Items(type="string", example="Email harus diisi")),
     *                 @OA\Property(property="password", type="array", @OA\Items(type="string", example="Password harus diisi"))
     *             )
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            // Log failed login attempt
            \Log::warning('Failed login attempt', [
                'email' => $request->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        
        // Log successful login
        \Log::info('Successful login', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => $request->ip(),
        ]);
        
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_at' => $user->created_at
                ]
            ]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/logout",
     *     tags={"Authentication"},
     *     summary="Logout Admin",
     *     description="Logout dan revoke token autentikasi",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout berhasil",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Logout berhasil")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/auth/user",
     *     tags={"Authentication"},
     *     summary="Get User Profile",
     *     description="Mendapatkan informasi user yang sedang login",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data user",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Berhasil mendapatkan data user"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Admin BPBD"),
     *                 @OA\Property(property="email", type="string", example="admin@bpbd.com"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
     */
    public function user(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mendapatkan data user',
            'data' => $request->user()
        ]);
    }

}





