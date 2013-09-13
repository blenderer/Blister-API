<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListitemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('liztitems', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('lizt_id');
			$table->text('item_text');
			$table->integer('order');
			$table->boolean('checked')->default(0);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('liztitems');
	}

}
