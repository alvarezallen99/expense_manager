<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use \App\Models\Role;
use \App\Models\Category;
use \App\Models\Expense;
use App\Helper\Helper;
use Crypt;
use Auth;

class RoleController extends Controller
{
    public function AddRole(Request $req)
    {
        try {
            $user = User::find(Auth::user()->id);
            if($user){

                $check_exists = Role::whereNull('deleted_at')
                                ->where('role_name', '=', $req->name)
                                ->exists();
                                
                if($check_exists){
                    return response()->json(['status' => 'fail', 'message' => 'Role Already Exists!'], 422);
                }

                // Validate Form
                if (ValidationController::validateAddRoleForm($req)) {
                    return ValidationController::validateAddRoleForm($req);
                }

                $update = Role::create([
                    'role_name' => $req->name,
                    'description' => $req->description,
                    'created_by' => $user->id,
                    'updated_by' => $user->id
                ]);

                $filtered = array();
                $new_data = Role::where('id', '=', $update->id)->get();

                for($x = 0; $x < count($new_data); $x++) {
                    array_push($filtered, [
                        'id' => $new_data[$x]->id,
                        'name' => $new_data[$x]->role_name,
                        'description' => $new_data[$x]->description,
                        'created_at' => Helper::formatDate($new_data[$x]->created_at),
                    ]);
                }

                // return response()->json(['status' => 'success', 'message' => encrypt(json_encode($filtered))], 200);
                return response()->json(['status' => 'success', 'message' => $filtered], 200);
            }

        } catch (\Throwable $th) {
            throw $th;
        }
        return response()->json(['error' => 'forbbiden'], 403);
    }

    public function UpdateRole(Request $req)
    {
        try {
            $user = User::find(Auth::user()->id);
            if($user){

                $check_exists = Role::whereNull('deleted_at')
                                ->where('id', '=', $req->id)
                                ->exists();
                
                if(!$check_exists){
                    return response()->json(['status' => 'fail', 'message' => 'Role Does not Exists!'], 422);
                }

                // Check Name if Already Exists
                $check_name_exists = Role::whereNull('deleted_at')
                                ->where('id', '!=', $req->id)
                                ->where('role_name', '=', $req->name)
                                ->exists();
                
                if($check_name_exists){
                    return response()->json(['status' => 'fail', 'message' => 'Role Name Already Exists!'], 422);
                }

                // Check if Administrator
                if($req->id == 1){
                    return response()->json(['status' => 'fail', 'message' => 'Modification Not Allowed On Current Role!'], 422);
                }

                // Validate Form
                if (ValidationController::validateUpdateRoleForm($req)) {
                    return ValidationController::validateUpdateRoleForm($req);
                }

                $update = Role::whereNull('deleted_at')
                    ->where('id', '=', $req->id)
                    ->where('id', '!=', 1)
                    ->update([
                        'role_name' => $req->name,
                        'description' => $req->description,
                        'updated_at' => date('Y:m:d H:m:s'),
                        'updated_by' => $user->id
                ]);

                $filtered = array();
                $new_data = Role::where('id', '=', $req->id)->first();

                array_push($filtered, [
                    'id' => $new_data->id,
                    'name' => $new_data->role_name,
                    'description' => $new_data->description,
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

    public function DeleteRole(Request $req)
    {
        try {
            $user = User::find(Auth::user()->id);
            if($user){

                $check_exists = Role::whereNull('deleted_at')
                                ->where('id', '=', $req->id)
                                ->exists();
                
                if(!$check_exists){
                    return response()->json(['status' => 'fail', 'message' => 'Role Does not Exists!'], 422);
                }

                // Check if Administrator
                if($req->id == 1){
                    return response()->json(['status' => 'fail', 'message' => 'Modification Not Allowed On Current Role!'], 422);
                }
                
                // Validate Form
                if (ValidationController::validateUpdateRoleForm($req)) {
                    return ValidationController::validateUpdateRoleForm($req);
                }

                Role::whereNull('deleted_at')
                    ->where('id', '=', $req->id)
                    ->update([
                        'deleted_at' => date('Y:m:d H:m:s'),
                        'updated_at' => date('Y:m:d H:m:s'),
                        'updated_by' => $user->id
                ]);

                return response()->json(['status' => 'success', 'message' => 'Role Successfully Deleted!'], 200);
            }

        } catch (\Throwable $th) {
            throw $th;
        }
        return response()->json(['error' => 'forbbiden'], 403);
    }
}
