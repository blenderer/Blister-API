<?php
 
class UserTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('users')->delete();
 
        User::create(array(
            'username' => 'blenderer',
            'password' => Hash::make('password')
        ));
 
        User::create(array(
            'username' => 'harrisone',
            'password' => Hash::make('password')
        ));
    }
 
}