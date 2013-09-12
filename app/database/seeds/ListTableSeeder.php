<?php
 
class ListTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('lists')->delete();
 
        Lizt::create(array(
            'user_id' => 1,
            'name' => 'Shopping List',
            'public' => false
        ));
        
        Lizt::create(array(
            'user_id' => 1,
            'name' => 'Christmas Wish List',
            'public' => true
        ));

        Lizt::create(array(
            'user_id' => 2,
            'name' => 'Chores 2/12',
            'public' => false
        ));

        Lizt::create(array(
            'user_id' => 2,
            'name' => 'List of Counties in Maryland',
            'public' => true
        ));
    }
 
}