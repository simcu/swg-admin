<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();
        DB::table('users')->truncate();
        DB::table('user_role_relations')->truncate();
        $role = Role::create(['id' => 1, 'name' => '系统管理员']);
        $role->users()->create(['username' => 'admin', 'password' => Hash::make('love1314')]);
    }
}
