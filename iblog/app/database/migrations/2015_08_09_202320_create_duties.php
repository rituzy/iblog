<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDuties extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('duties', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('year');
			$table->integer('month');			
            $table->integer('monthPart');			
			$table->integer('worker_id')->unsigned();
			$table->foreign('worker_id')->references('id')->on('workers');
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
		Schema::table('duties', function(Blueprint $table) {			
			$table->drop();
		});
	}

}
