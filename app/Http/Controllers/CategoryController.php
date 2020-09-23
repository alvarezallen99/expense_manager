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

class CategoryController extends Controller
{
    public function AddCategory(Request $req)
    {
        try {
            $user = User::find(Auth::user()->id);
            if($user){

                $check_exists = Category::whereNull('deleted_at')
                                ->where('category_name', '=', $req->category_name)
                                ->exists();
                                
                if($check_exists){
                    return response()->json(['status' => 'fail', 'message' => 'Expense Category Already Exists!'], 422);
                }

                // Validate Form
                if (ValidationController::validateAddCategoryForm($req)) {
                    return ValidationController::validateAddCategoryForm($req);
                }

                $update = Category::create([
                    'category_name' => $req->category_name,
                    'description' => $req->description,
                    'created_by' => $user->id,
                    'updated_by' => $user->id
                ]);

                $filtered = array();
                $new_data = Category::where('id', '=', $update->id)->get();

                for($x = 0; $x < count($new_data); $x++) {
                    array_push($filtered, [
                        'id' => $new_data[$x]->id,
                        'category_name' => $new_data[$x]->category_name,
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

    public function UpdateCategory(Request $req)
    {
        try {
            $user = User::find(Auth::user()->id);
            if($user){

                $check_exists = Category::whereNull('deleted_at')
                                ->where('id', '=', $req->id)
                                ->exists();
                
                if(!$check_exists){
                    return response()->json(['status' => 'fail', 'message' => 'Expense Category Does not Exists!'], 422);
                }

                // Check Name if Already Exists
                $check_name_exists = Category::whereNull('deleted_at')
                                ->where('id', '!=', $req->id)
                                ->where('category_name', '=', $req->category_name)
                                ->exists();
                
                if($check_name_exists){
                    return response()->json(['status' => 'fail', 'message' => 'Expense Category Already Exists!'], 422);
                }

                // Validate Form
                if (ValidationController::validateUpdateCategoryForm($req)) {
                    return ValidationController::validateUpdateCategoryForm($req);
                }

                $update = Category::whereNull('deleted_at')
                    ->where('id', '=', $req->id)
                    ->where('id', '!=', 1)
                    ->update([
                        'category_name' => $req->category_name,
                        'description' => $req->description,
                        'updated_at' => date('Y:m:d H:m:s'),
                        'updated_by' => $user->id
                ]);

                $filtered = array();
                $new_data = Category::where('id', '=', $req->id)->first();

                array_push($filtered, [
                    'id' => $new_data->id,
                    'category_name' => $new_data->category_name,
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

    public function DeleteCategory(Request $req)
    {
        try {
            $user = User::find(Auth::user()->id);
            if($user){

                $check_exists = Category::whereNull('deleted_at')
                                ->where('id', '=', $req->id)
                                ->exists();
                
                if(!$check_exists){
                    return response()->json(['status' => 'fail', 'message' => 'Expense Category Does not Exists!'], 422);
                }
                
                // Validate Form
                if (ValidationController::validateUpdateCategoryForm($req)) {
                    return ValidationController::validateUpdateCategoryForm($req);
                }

                Category::whereNull('deleted_at')
                    ->where('id', '=', $req->id)
                    ->update([
                        'deleted_at' => date('Y:m:d H:m:s'),
                        'updated_at' => date('Y:m:d H:m:s'),
                        'updated_by' => $user->id
                ]);

                return response()->json(['status' => 'success', 'message' => 'Expense Category Successfully Deleted!'], 200);
            }

        } catch (\Throwable $th) {
            throw $th;
        }
        return response()->json(['error' => 'forbbiden'], 403);
    }
}
