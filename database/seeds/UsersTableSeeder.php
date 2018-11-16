<?php

use Illuminate\Database\Seeder;
use App\Models\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User();
        $admin->name = 'Dima Maimesko';
        $admin->email = 'dima.maimesko@gmail.com';
        $admin->email_verified_at = now();
        $admin->password = bcrypt('111111');
        $admin->remember_token = str_random(10);
        $admin->save();

        factory(User::class, 10)->create();


    }
}
