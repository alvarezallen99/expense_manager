<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route to handle page reload in Vue except for api routes
Route::get('/{any?}', 'SinglePageController')->where('any', '^(?!api\/)[\/\w\.-]*');

Route::prefix('v1')->group(function () {
    
    Route::prefix('auth')->group(function () {

        Route::post('login_check', 'AuthController@login');

        Route::post('logout', 'AuthController@logout');

    });
    // Below mention routes are available only for authenticated users.
    Route::middleware('auth:api')->group(function (){
        /**
         * Roles
         */
        Route::post('roles', 'DataController@LoadRoles');

        Route::post('add_role', 'RoleController@AddRole');

        Route::post('update_role', 'RoleController@UpdateRole');

        Route::post('delete_role', 'RoleController@DeleteRole');

        /**
         * Users
         */

        Route::post('users', 'DataController@LoadUsers');

        Route::post('add_user', 'UserController@AddUser');

        Route::post('update_user', 'UserController@UpdateUser');

        Route::post('delete_user', 'UserController@DeleteUser');

        Route::post('change_password', 'UserController@UpdatePassword');

        /**
         * Categories
         */

        Route::post('categories', 'DataController@LoadCategories');

        Route::post('add_category', 'CategoryController@AddCategory');

        Route::post('update_category', 'CategoryController@UpdateCategory');

        Route::post('delete_category', 'CategoryController@DeleteCategory');
        
        /**
         * Expenses
         */

        Route::post('expenses', 'DataController@LoadExpenses');

        Route::post('add_expenses', 'ExpenseController@AddExpenses');

        Route::post('update_expenses', 'ExpenseController@UpdateExpenses');

        Route::post('delete_expenses', 'ExpenseController@DeleteExpenses');
        
        /**
         * Dashboard
         */
        
        Route::post('dashboard', 'DataController@LoadDashboard');

        Route::post('pie', 'DataController@LoadPie');
    });        
});