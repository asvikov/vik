<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Article;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'admin',
            'lastname' => 'lastnameadmin'
        ]);

        DB::table('roles')
            ->insert([
                [
                    'name' => 'guest',
                    'title' => 'гость'
                ],
                [
                    'name' => 'admin',
                    'title' => 'администратор'
                ],
                [
                    'name' => 'manager',
                    'title' => 'менеджер'
                ]
            ]);

        $role = Role::where('name', 'admin')->first();

        DB::table('role_user')
            ->insert([
                [
                    'role_id' => $role->id,
                    'user_id' => $user->id
                ]
            ]);

        Address::factory()->create();

        Article::factory(5)->create();
    }
}
