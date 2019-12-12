<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Create admin account
         */
        factory(User::class)->create([
            'role_id' => 1,
            'name' => 'Mr Admin',
            'email' => 'admin@e-tutor.com',
            'password' => Hash::make('admin123')
        ]);

        /**
         * Create staff accounts
         */
        factory(User::class, 1)->create([
            'role_id' => 2,
            'password' => Hash::make('123456')
        ]);

        /**
         * Create tutors accounts
         */
        factory(User::class, 50)->create([
            'role_id' => 3,
            'password' => Hash::make('67890')
        ]);

        /**
         * Create tutors accounts
         */
        factory(User::class, 10)->create();
    }
}
