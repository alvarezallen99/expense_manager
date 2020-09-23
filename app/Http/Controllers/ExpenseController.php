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

class ExpenseController extends Controller
{
    public function AddExpenses(Request $req)
    {
        try {
            $user = User::find(Auth::user()->id);
            if($user){

                $check_exists = Category::whereNull('deleted_at')
                                ->where('category_name', '=', $req->category_name)
                                ->exists();
                                
                if(!$check_exists){
                    return response()->json(['status' => 'fail', 'message' => 'Expense Category Not Exists!'], 422);
                }

                // Validate Form
                if (ValidationController::validateAddExpenseForm($req)) {
                    return ValidationController::validateAddExpenseForm($req);
                }

                $category = Category::whereNull('deleted_at')
                                ->where('category_name', '=', $req->category_name)
                                ->first();

                $create = Expense::create([
                    'category_id' => $category->id,
                    'amount' => $req->amount,
                    'entry_date' => $req->entry_date,
                    'created_by' => $user->id,
                    'updated_by' => $user->id
                ]);

                $filtered = array();
                // $new_data = Expense::whereNull('expenses.deleted_at')
                //             ->where('expenses.id', '=', $create->id)
                //             ->join('categories', 'categories.id', '=', 'expenses.id')
                //             ->select('expenses.id', 'categories.id as category_id', 'categories.category_name', 'expenses.amount', 'expenses.entry_date', 'expenses.created_at')
                //             ->first();

                array_push($filtered, [
                    'id' => $create->id,
                    'category_id' => $create->category_id,
                    'category_name' => $req->category_name,
                    'amount' => $create->amount,
                    'entry_date' => Helper::formatDate($create->entry_date),
                    'created_at' => Helper::formatDate($create->created_at),
                ]);

                // return response()->json(['status' => 'success', 'message' => encrypt(json_encode($filtered))], 200);
                return response()->json(['status' => 'success', 'message' => $filtered], 200);
            }

        } catch (\Throwable $th) {
            throw $th;
        }
        return response()->json(['error' => 'forbbiden'], 403);
    }

    public function UpdateExpenses(Request $req)
    {
        try {
            $user = User::find(Auth::user()->id);
            if($user){

                $check_exists = Category::whereNull('deleted_at')
                                ->where('category_name', '=', $req->category_name)
                                ->exists();
                                
                if(!$check_exists){
                    return response()->json(['status' => 'fail', 'message' => 'Expense Category Not Exists!'], 422);
                }

                // Validate Form
                if (ValidationController::validateUpdateExpenseForm($req)) {
                    return ValidationController::validateUpdateExpenseForm($req);
                }

                // Get Category Id
                $category = Category::whereNull('deleted_at')
                                ->where('category_name', '=', $req->category_name)
                                ->first();

                $update = Expense::whereNull('deleted_at')
                    ->where('id', '=', $req->id)
                    ->update([
                        'category_id' => $category->id,
                        'amount' => $req->amount,
                        'entry_date' => $req->entry_date,
                        'updated_at' => date('Y:m:d H:m:s'),
                        'updated_by' => $user->id
                ]);

                $filtered = array();
                $new_data = Expense::where('id', '=', $req->id)->first();
                
                array_push($filtered, [
                    'id' => $new_data->id,
                    'category_id' => $new_data->category_id,
                    'category_name' => $req->category_name,
                    'amount' => $new_data->amount,
                    'entry_date' => Helper::formatDate($new_data->entry_date),
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

    public function DeleteExpenses(Request $req)
    {
        try {
            $user = User::find(Auth::user()->id);
            if($user){

                $check_exists = Expense::whereNull('deleted_at')
                                ->where('id', '=', $req->id)
                                ->exists();
                
                if(!$check_exists){
                    return response()->json(['status' => 'fail', 'message' => 'Expenses Does not Exists!'], 422);
                }
                
                // Get Category Id
                $category = Category::whereNull('deleted_at')
                                ->where('category_name', '=', $req->category_name)
                                ->first();

                if(!$category){
                    return response()->json(['status' => 'fail', 'message' => 'Expenses Category Does not Exists!'], 422);
                }

                // Validate Form
                if (ValidationController::validateUpdateExpenseForm($req)) {
                    return ValidationController::validateUpdateExpenseForm($req);
                }

                Expense::whereNull('deleted_at')
                    ->where('id', '=', $req->id)
                    ->update([
                        'deleted_at' => date('Y:m:d H:m:s'),
                        'updated_at' => date('Y:m:d H:m:s'),
                        'updated_by' => $user->id
                ]);

                return response()->json(['status' => 'success', 'message' => 'Expense Successfully Deleted!'], 200);
            }

        } catch (\Throwable $th) {
            throw $th;
        }
        return response()->json(['error' => 'forbbiden'], 403);
    }
}
