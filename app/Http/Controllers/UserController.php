<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use \App\Models\Role;
use \App\Models\Category;
use \App\Models\Expense;
use App\Helper\Helper;
use Crypt;
use Hash;
use Auth;

class UserController extends Controller
{
    public function AddUser(Request $req)
    {
        try {
            $user = User::find(Auth::user()->id);
            if($user){

                $check_exists = User::whereNull('deleted_at')
                                ->where('email', '=', $req->email)
                                ->exists();
                                
                if($check_exists){
                    return response()->json(['status' => 'fail', 'message' => 'Email Already Exists!'], 422);
                }

                // Validate Form
                if (ValidationController::validateAddUserForm($req)) {
                    return ValidationController::validateAddUserForm($req);
                }

                $role = Role::whereNull('deleted_at')
                            ->where('role_name', '=', $req->role_name)
                            ->first();

                $create = User::create([
                    'name' => $req->name,
                    'email' => $req->email,
                    'password' => Hash::make($req->password),
                    'role' => $role->id,
                    'created_by' => $user->id,
                    'updated_by' => $user->id
                ]);

                $filtered = array();
                $new_data = User::where('users.id', '=', $create->id)
                                ->join('roles', 'roles.id', '=', 'users.role')
                                ->select('users.id', 'users.name', 'users.email', 'users.role', 'roles.role_name', 'users.created_at')
                                ->first();

                array_push($filtered, [
                    'id' => $new_data->id,
                    'name' => $new_data->name,
                    'email' => $new_data->email,
                    'role' => $new_data->role,
                    'role_name' => $new_data->role_name,
                    'created_at' => Helper::formatDate($new_data->created_at),
                ]);

                // return response()->json(['status' => 'success', 'message' => encrypt(json_encode($filtered))], 200);
                return response()->json(['status' => 'success', 'message' => $filtered], 200);
            }

        } catch (\Throwable $th) {
            throw $th;
        }
        return response()->json(['error' => 'forbbiden'], 403);
    }

    public function UpdateUser(Request $req)
    {
        try {
            $user = User::find(Auth::user()->id);
            if($user){

                $check_exists = User::whereNull('deleted_at')
                                ->where('email', '=', $req->email)
                                ->exists();
                
                if(!$check_exists){
                    return response()->json(['status' => 'fail', 'message' => 'Email Does not Exists!'], 422);
                }

                // Check Email if Already Exists
                $check_email_exists = User::whereNull('deleted_at')
                                ->where('id', '!=', $req->id)
                                ->where('email', '=', $req->email)
                                ->exists();
                
                if($check_email_exists){
                    return response()->json(['status' => 'fail', 'message' => 'Email Already Exists!'], 422);
                }

                // Get Id requested Role Name
                $role = Role::whereNull('deleted_at')
                            ->where('role_name', '=', $req->role_name)
                            ->first();

                // Check if Administrator
                $isAdmin = User::whereNull('deleted_at')
                        ->where('id', '=', $req->id)
                        ->where('role', '=', 1)->exists();

                if($isAdmin && $role->id != 1){
                    return response()->json(['status' => 'fail', 'message' => 'Administrator Role Cannot be Updated!'], 422);
                }

                // Validate Form
                if (ValidationController::validateUpdateUserForm($req)) {
                    return ValidationController::validateUpdateUserForm($req);
                }

                User::whereNull('deleted_at')
                    ->where('id', '=', $req->id)
                    ->update([
                        'name' => $req->name,
                        'email' => $req->email,
                        'password' => Hash::make($req->password),
                        'role' => $role->id,
                        'updated_at' => date('Y:m:d H:m:s'),
                        'updated_by' => $user->id
                ]);

                $filtered = array();
                $new_data = User::where('users.id', '=', $req->id)
                                ->join('roles', 'roles.id', '=', 'users.role')
                                ->select('users.id', 'users.name', 'users.email', 'users.role', 'roles.role_name', 'users.created_at')
                                ->first();

                array_push($filtered, [
                    'id' => $new_data->id,
                    'name' => $new_data->name,
                    'email' => $new_data->email,
                    'role' => $new_data->role,
                    'role_name' => $new_data->role_name,
                    'created_at' => Helper::formatDate($new_data->created_at),
                ]);

                // return response()->json(['status' => 'success', 'message' => encrypt(json_encode($filtered))], 200);
                return response()->json(['status' => 'success', 'message' => $filtered], 200);
            }

        } catch (\Throwable $th) {
            throw $th;
        }
        return response()->json(['error' => 'forbbiden'], 403);
    }

    public function DeleteUser(Request $req)
    {
        try {
            $user = User::find(Auth::user()->id);
            if($user){

                $check_exists = User::whereNull('deleted_at')
                                ->where('id', '=', $req->id)
                                ->exists();
                
                if(!$check_exists){
                    return response()->json(['status' => 'fail', 'message' => 'User Does not Exists!'], 422);
                }
                
                // Check if Administrator
                $isAdmin = User::whereNull('deleted_at')
                    ->where('id', '=', $req->id)
                    ->where('role', '=', 1)->exists();
                if($req->id == 1 || $isAdmin){
                    return response()->json(['status' => 'fail', 'message' => 'Delete Not Allowed On Administrator Role!'], 422);
                }

                User::whereNull('deleted_at')
                    ->where('id', '=', $req->id)
                    ->update([
                        'deleted_at' => date('Y:m:d H:m:s'),
                        'updated_at' => date('Y:m:d H:m:s'),
                        'updated_by' => $user->id
                ]);

                return response()->json(['status' => 'success', 'message' => 'User Successfully Deleted!'], 200);
            }

        } catch (\Throwable $th) {
            throw $th;
        }
        return response()->json(['error' => 'forbbiden'], 403);
    }

    public function UpdatePassword(Request $req)
    {
        try {
            $user = User::find(Auth::user()->id);
            if($user){

                $check_exists = User::whereNull('deleted_at')
                                ->where('id', '=', $user->id)
                                ->exists();
                
                if(!$check_exists){
                    return response()->json(['status' => 'fail', 'message' => 'User Does not Exists!'], 422);
                }

                // Validate Form
                if (ValidationController::validateUserPassword($req)) {
                    return ValidationController::validateUserPassword($req);
                }

                User::whereNull('deleted_at')
                    ->where('id', '=', $user->id)
                    ->update([
                        'password' => Hash::make($req->password),
                        'updated_at' => date('Y:m:d H:m:s'),
                        'updated_by' => $user->id
                ]);

                return response()->json(['status' => 'success', 'message' => 'User Successfully Deleted!'], 200);
            }

        } catch (\Throwable $th) {
            throw $th;
        }
        return response()->json(['error' => 'forbbiden'], 403);
    }
}
