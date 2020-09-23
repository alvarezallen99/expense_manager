<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use \App\Models\User;
use \App\Models\Role;
use \App\Models\Category;
use \App\Models\Expense;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        $users = array(
            ['name' => 'Juan Dela Cruz', 'email' => 'juan@expensemanager.com', 'password' => Hash::make('password'), 'role' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => 'Leo Ocampo', 'email' => 'leo@expensemanager.com', 'password' => Hash::make('password'), 'role' => 2, 'created_by' => 1, 'updated_by' => 1],
        );

        // Loop through each user above and create the record for them in the database
        foreach ($users as $user)
        {
            User::create($user);
        }

        Role::truncate();
        $roles = array(
            ['id' => 1, 'role_name' => 'Administrator', 'description' => 'super user', 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1, 'updated_at' => date('Y-m-d H:i:s'), 'updated_by' => 1],
            ['id' => 2, 'role_name' => 'User', 'description' => 'can add expenses', 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1, 'updated_at' => date('Y-m-d H:i:s'), 'updated_by' => 1],
        );

        // Loop through each user above and create the record for them in the database
        foreach ($roles as $role)
        {
            Role::create($role);
        }

        Category::truncate();
        $categories = array(
            ['id' => 1, 'category_name' => 'Travel', 'description' => 'daily commute', 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1, 'updated_at' => date('Y-m-d H:i:s'), 'updated_by' => 1],
            ['id' => 2, 'category_name' => 'Entertainment', 'description' => 'movies etc', 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1, 'updated_at' => date('Y-m-d H:i:s'), 'updated_by' => 1],
        );

        // Loop through each user above and create the record for them in the database
        foreach ($categories as $category)
        {
            Category::create($category);
        }

        Expense::truncate();
        $expenses = array(
            ['category_id' => 1, 'amount' => '230', 'entry_date' => date('Y-m-d H:i:s'), 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1, 'updated_at' => date('Y-m-d H:i:s'), 'updated_by' => 1],
            ['category_id' => 1, 'amount' => '20', 'entry_date' => date('Y-m-d H:i:s'), 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1, 'updated_at' => date('Y-m-d H:i:s'), 'updated_by' => 1],
            ['category_id' => 2, 'amount' => '530', 'entry_date' => date('Y-m-d H:i:s'), 'created_at' => date('Y-m-d H:i:s'), 'created_by' => 1, 'updated_at' => date('Y-m-d H:i:s'), 'updated_by' => 1],
        );

        // Loop through each user above and create the record for them in the database
        foreach ($expenses as $expense)
        {
            Expense::create($expense);
        }
    }
}
