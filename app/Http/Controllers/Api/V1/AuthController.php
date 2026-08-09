<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Models\AuditLog;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Throwable;

class AuthController extends Controller
{
    /**
     * @throws Exception|Throwable
     */
    public function register(RegisterRequest $request)
    {
        try {
            $result = DB::transaction(function () use ($request) {
                $validatedData = $request->validated();
                $validatedData['password'] = Hash::make($validatedData['password']);
                $validatedData['role_id'] = $validatedData['role_id'] ?? Role::student;

                $user = User::create($validatedData);

                AuditLog::create([
                    'user_id' => $user->id,
                    'action' => 'user_registered',
                    'entity_type' => 'users',
                    'entity_id' => $user->id,
                    'new_data' => ['email' => $validatedData['email']]
                ]);

                if (isset($validatedData['teams']))
                    $user->teams()->attach($validatedData['teams']);

                $access_token = $user->createToken('access_token',['*'])->plainTextToken;
                $refresh_token = $user->createToken('refresh_token',['refresh'])->plainTextToken;

                return compact('user', 'access_token', 'refresh_token');
            });
            $result['user']->load(['role']);

            return response()->json([
                'success' => true,
                'data' => [
                    'user' => $result['user'],
                    'access_token' => $result['access_token'],
                    'refresh_token' => $result['refresh_token'],
                    'role_name' => $result['user']->role->name ?? Role::student,
                ],
                'message' => 'user signup successfully',
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while signing up',
                'error' => $e->getMessage(),
            ],500);
        }
    }
    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::where('email', $validatedData['email'])->first();

        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 'INVALID_CREDENTIALS',
                    'message' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة',
                ],
            ], 401);
        }

        $user->last_login_at = now();
        $user->save();

        $accessToken = $user->createToken('access_token',['*'])->plainTextToken;
        $refreshToken = $user->createToken('refresh_token',['refresh'])->plainTextToken;


        $user->load(['role']);

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user->load('role'),
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken,
                'role_name' => $user->role->name ?? Role::student,
                'expires_in' => 86400,
            ],
            'message' => 'Login successful',
        ]);
    }
    public function logout(Request $request)
    {
        /** @var PersonalAccessToken $token */
        $token = $request->user()->currentAccessToken();
        $token->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully',
        ]);
    }
    public function refresh(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        $access_token = $user->createToken('api-access_token',['*'])->plainTextToken;
        $refresh_token = $user->createToken('api-refresh-token',['refresh'])->plainTextToken;

        return response()->json([
            'success' => true,
            'data' => [
                'access_token' => $access_token,
                'refresh_token' => $refresh_token,
                'expires_in' => 86400,
            ],
        ]);
    }
}
