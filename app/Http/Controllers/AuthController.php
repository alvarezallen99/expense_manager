<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use Auth;
use Crypt;
use Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            if (ValidationController::validateLoginForm($request)) {
                return ValidationController::validateLoginForm($request);
            }

            $user = User::where('email', $request->email)
                ->first();

            if ($user) {
                $sqlData = User::where('email', $request->email)->select('id', 'password')->first();
                $hashedPassword = $sqlData->password;

                if (!empty($hashedPassword)) {
                    if (Hash::check($request->password, $hashedPassword)) {
                        $token = Auth::login($user);

                        $userData = User::where('email', $request->email)
                            ->join('roles', 'roles.id', '=', 'users.role')->first();
                        $userData->token = $token;
                        $userData = json_encode($userData);
                        $userData = Crypt::encrypt($userData);

                        return response()->json([
                            'status' => 'success',
                            'UserData' => $userData
                        ], 200)->header('Authorization', $token);
                    }
                }
            }
            return response()->json(['error' => 'login_error'], 401);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json(['error' => 'database_error'], 500);
        }
        // $credentials = $request->only('username', 'password');
        // if ($token = $this->guard()->attempt($credentials)) {
        //     return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
        // }
        // return response()->json(['error' => $credentials], 401);
    }

    /**
     * Logout User
     */
    public function logout()
    {
        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }

    /**
     * Get Authenticated User
     */
    public function user(Request $request)
    {
        $user = User::find(Auth::user()->userid);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    /**
     * Referesh JWT Token
     */
    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'success'], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }

    /**
     * Return auth guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}
