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
            ListItem::create(array(
                'list_id' => 1,
                'item_text' => 'Milk',
                'order' => '0'
            ));
            ListItem::create(array(
                'list_id' => 1,
                'item_text' => 'Eggs',
                'order' => '1'
            ));
            ListItem::create(array(
                'list_id' => 1,
                'item_text' => 'Bread',
                'order' => '2'
            ));
            ListItem::create(array(
                'list_id' => 1,
                'item_text' => 'Meat',
                'order' => '3'
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