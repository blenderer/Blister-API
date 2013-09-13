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
            ListItem::create(array(
                'list_id' => 2,
                'item_text' => 'Mechanical Keyboard',
                'order' => '0'
            ));
            ListItem::create(array(
                'list_id' => 2,
                'item_text' => 'Samsung Galaxy S4',
                'order' => '1'
            ));
            ListItem::create(array(
                'list_id' => 2,
                'item_text' => 'Craft Beer',
                'order' => '2'
            ));
            ListItem::create(array(
                'list_id' => 2,
                'item_text' => 'Medieval Mace Weapon',
                'order' => '3'
            ));

        Lizt::create(array(
            'user_id' => 2,
            'name' => 'Chores 2/12',
            'public' => false
        ));
            ListItem::create(array(
                'list_id' => 3,
                'item_text' => 'Dishes',
                'order' => '0'
            ));
            ListItem::create(array(
                'list_id' => 3,
                'item_text' => 'Take out trash',
                'order' => '1'
            ));
            ListItem::create(array(
                'list_id' => 3,
                'item_text' => 'Clean car',
                'order' => '2'
            ));
            ListItem::create(array(
                'list_id' => 3,
                'item_text' => 'Tidy-up Desk',
                'order' => '3'
            ));

        Lizt::create(array(
            'user_id' => 2,
            'name' => 'List of Counties in Maryland',
            'public' => true
        ));
            ListItem::create(array(
                'list_id' => 4,
                'item_text' => 'Baltimore City',
                'order' => '0'
            ));
            ListItem::create(array(
                'list_id' => 4,
                'item_text' => 'Howard ',
                'order' => '1'
            ));
            ListItem::create(array(
                'list_id' => 4,
                'item_text' => 'Montgomery',
                'order' => '2'
            ));
            ListItem::create(array(
                'list_id' => 4,
                'item_text' => 'Charles',
                'order' => '3'
            ));
    }
 
}