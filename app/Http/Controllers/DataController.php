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

class DataController extends Controller
{
    public function LoadPie(Request $req)
    {
        try {
            $user = User::find(Auth::user()->id);
            if($user){

                $labels = array();
                $borderColor = array();
                $backgroundColor = array();
                $data = array();

                $sqldata = Expense::whereNull('expenses.deleted_at')
                        ->leftJoin('categories', 'categories.id', '=', 'expenses.category_id')
                        ->select('categories.category_name')
                        ->selectRaw('sum(expenses.amount) as total_amount')
                        ->groupBy('expenses.category_id')
                        ->get();


                for($x = 0; $x < count($sqldata); $x++) {
                    array_push($labels, $sqldata[$x]->category_name);
                    array_push($data, $sqldata[$x]->total_amount);
                }

                return response()->json([
                    'status' => 'success', 
                    'labels' => $labels,
                    'borderColor' => $borderColor,
                    'backgroundColor' => $backgroundColor,
                    'data' => $data,
                ], 200);
            }

        } catch (\Throwable $th) {
            throw $th;
        }
        return response()->json(['error' => 'forbbiden'], 403);
    }

    public function LoadDashboard(Request $req)
    {
        try {
            $user = User::find(Auth::user()->id);
            if($user){

                $filtered = array();
                $data = Expense::whereNull('expenses.deleted_at')
                        ->leftJoin('categories', 'categories.id', '=', 'expenses.category_id')
                        ->select('categories.category_name')
                        ->selectRaw('sum(expenses.amount) as total_amount')
                        ->groupBy('expenses.category_id')
                        ->get();

                for($x = 0; $x < count($data); $x++) {
                    array_push($filtered, [
                        'category_name' => $data[$x]->category_name,
                        'total_amount' => $data[$x]->total_amount
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

    public function LoadRoles(Request $req)
    {
        try {
            $user = User::find(Auth::user()->id);
            if($user){

                $filtered = array();
                $data = Role::whereNull('deleted_at')->get();

                for($x = 0; $x < count($data); $x++) {
                    array_push($filtered, [
                        'id' => $data[$x]->id,
                        'name' => $data[$x]->role_name,
                        'description' => $data[$x]->description,
                        'created_at' => Helper::formatDate($data[$x]->created_at),
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

    public function LoadCategories(Request $req)
    {
        try {
            $user = User::find(Auth::user()->id);
            if($user){

                $filtered = array();
                $data = Category::whereNull('deleted_at')->get();

                for($x = 0; $x < count($data); $x++) {
                    array_push($filtered, [
                        'id' => $data[$x]->id,
                        'category_name' => $data[$x]->category_name,
                        'description' => $data[$x]->description,
                        'created_at' => Helper::formatDate($data[$x]->created_at),
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

    public function LoadExpenses(Request $req)
    {
        try {
            $user = User::find(Auth::user()->id);
            if($user){

                $filtered = array();
                $data = Expense::whereNull('expenses.deleted_at')
                            ->whereNull('categories.deleted_at')
                            ->join('categories', 'categories.id', '=', 'expenses.category_id')
                            ->select('expenses.id', 'expenses.category_id', 'categories.category_name', 'expenses.amount', 'expenses.entry_date', 'expenses.created_at')
                            ->get();

                for($x = 0; $x < count($data); $x++) {
                    array_push($filtered, [
                        'id' => $data[$x]->id,
                        'category_id' => $data[$x]->category_id,
                        'category_name' => $data[$x]->category_name,
                        'amount' => $data[$x]->amount,
                        'entry_date' => Helper::formatDate($data[$x]->entry_date),
                        'created_at' => Helper::formatDate($data[$x]->created_at),
                    ]);
                }

                // Get Categories Master
                $filtered_roles = array();
                $categories = Category::whereNull('deleted_at')->get();
                for($x = 0; $x < count($categories); $x++) {
                    array_push($filtered_roles, $categories[$x]->category_name);
                }

                // return response()->json(['status' => 'success', 'message' => encrypt(json_encode($filtered))], 200);
                return response()->json(['status' => 'success', 'message' => $filtered, 'categories' => $filtered_roles], 200);
            }

        } catch (\Throwable $th) {
            throw $th;
        }
        return response()->json(['error' => 'forbbiden'], 403);
    }

    public function LoadUsers(Request $req)
    {
        try {
            $user = User::find(Auth::user()->id);
            if($user){

                $filtered = array();
                $data = User::whereNull('users.deleted_at')
                        ->whereNull('roles.deleted_at')
                        ->join('roles', 'roles.id', '=', 'users.role')
                        ->select('users.id', 'users.name', 'users.email', 'users.role', 'roles.role_name', 'users.created_at')
                        ->get();

                for($x = 0; $x < count($data); $x++) {
                    array_push($filtered, [
                        'id' => $data[$x]->id,
                        'name' => $data[$x]->name,
                        'email' => $data[$x]->email,
                        'role' => $data[$x]->role,
                        'role_name' => $data[$x]->role_name,
                        'created_at' => Helper::formatDate($data[$x]->created_at),
                    ]);
                }

                // Get Role Master
                $filtered_roles = array();
                $roles = Role::whereNull('deleted_at')->get();
                for($x = 0; $x < count($roles); $x++) {
                    array_push($filtered_roles, $roles[$x]->role_name);
                }
                // return response()->json(['status' => 'success', 'message' => encrypt(json_encode($filtered))], 200);
                return response()->json(['status' => 'success', 'message' => $filtered, 'roles' => $filtered_roles], 200);
            }

        } catch (\Throwable $th) {
            throw $th;
        }
        return response()->json(['error' => 'forbbiden'], 403);
    }
}
