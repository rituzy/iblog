<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrafts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('crafts', function(Blueprint $table) {
			$table->increments('id');
			$table->text('title');
			$table->text('description');
			$table->text('link');
			$table->string('image');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->text('title_ru');
			$table->text('description_ru');	
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('crafts', function(Blueprint $table) {			
			$table->drop();
		});
	}

}
