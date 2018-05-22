<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();
        DB::table('users')->truncate();
        DB::table('user_role_relations')->truncate();
        $role = Role::create(['id' => 1, 'name' => '系统管理员']);
        $role->users()->create(['username' => 'admin', 'password' => Hash::make('love1314'), 'enable' => true]);
    }
}
