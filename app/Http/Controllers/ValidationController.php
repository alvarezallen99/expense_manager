<?php

namespace App\Http\Controllers;
use Validator;

use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public static function validateAddRoleForm(Request $req){
        $v = Validator::make($req->all(), [
            'name' => 'required|max:50',
            'description' => 'required|max:80',
        ]);
        if($v->fails())
        {
            return response()->json(['status' => 'error', 'errors' => $v->errors()], 422);
        }
    }

    public static function validateUpdateRoleForm(Request $req){
        $v = Validator::make($req->all(), [
            'id' => 'required',
            'name' => 'required|max:50',
            'description' => 'required|max:80',
        ]);
        if($v->fails())
        {
            return response()->json(['status' => 'error', 'errors' => $v->errors()], 422);
        }
    }

    public static function validateAddCategoryForm(Request $req){
        $v = Validator::make($req->all(), [
            'category_name' => 'required|max:50',
            'description' => 'required|max:80',
        ]);
        if($v->fails())
        {
            return response()->json(['status' => 'error', 'errors' => $v->errors()], 422);
        }
    }

    public static function validateUpdateCategoryForm(Request $req){
        $v = Validator::make($req->all(), [
            'id' => 'required',
            'category_name' => 'required|max:50',
            'description' => 'required|max:80',
        ]);
        if($v->fails())
        {
            return response()->json(['status' => 'error', 'errors' => $v->errors()], 422);
        }
    }

    public static function validateAddUserForm(Request $req){
        $v = Validator::make($req->all(), [
            'name' => 'required|max:50',
            'email' => 'required|email',
            'password' => 'required|max:80',
            'role_name' => 'required',
        ]);
        if($v->fails())
        {
            return response()->json(['status' => 'error', 'errors' => $v->errors()], 422);
        }
    }

    public static function validateUpdateUserForm(Request $req){
        if(!$req->id){
            return response()->json(['status' => 'error', 'errors' => 'Invalid Transaction'], 422);
        }
        $v = Validator::make($req->all(), [
            'id' => 'required',
            'name' => 'required|max:50',
            'email' => 'required|email',
            'password' => 'required|max:80',
            'role_name' => 'required',
        ]);
        if($v->fails())
        {
            return response()->json(['status' => 'error', 'errors' => $v->errors()], 422);
        }
    }
    
    public static function validateAddExpenseForm(Request $req){
        $v = Validator::make($req->all(), [
            'category_name' => 'required|max:50',
            'amount' => 'required|numeric',
            'entry_date' => 'required|date',
        ]);
        if($v->fails())
        {
            return response()->json(['status' => 'error', 'errors' => $v->errors()], 422);
        }
    }

    public static function validateUpdateExpenseForm(Request $req){
        $v = Validator::make($req->all(), [
            'id' => 'required',
            'category_name' => 'required|max:50',
            'amount' => 'required|numeric',
            'entry_date' => 'required|date',
        ]);
        if($v->fails())
        {
            return response()->json(['status' => 'error', 'errors' => $v->errors()], 422);
        }
    }

    public static function validateLoginForm(Request $req){
        $v = Validator::make($req->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if($v->fails())
        {
            return response()->json(['status' => 'error', 'errors' => $v->errors()], 422);
        }
    }

    public static function validateUserPassword(Request $req){
        $v = Validator::make($req->all(), [
            'password' => 'required|min:5|max:25|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|min:5|max:25',
        ]);
        if($v->fails())
        {
            return response()->json(['status' => 'error', 'errors' => $v->errors()], 422);
        }
    }
}
