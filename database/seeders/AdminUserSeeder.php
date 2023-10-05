<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory(1)->create(['email' => 'admin@admin.com']);
        $role = Role::where('slug', 'admin')->firstOrFail();

        UserRole::create([
            'user_id' => $user[0]->id,
            'role_id' => $role->id
        ]);
    }
}
