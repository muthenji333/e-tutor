<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Role::class)->create(['name'=>'admin']);
        factory(Role::class)->create(['name'=>'staff']);
        factory(Role::class)->create(['name'=>'tutor']);
        factory(Role::class)->create(['name'=>'tutee']);
    }
}
