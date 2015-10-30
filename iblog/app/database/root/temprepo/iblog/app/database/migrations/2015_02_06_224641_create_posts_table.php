<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


class CreatePostsTable extends Migration {

/**
 * Run the migrations.
 *
 * @return void
 */
public function up()
{
	Schema::create('posts', function(Blueprint $table) {
		$table->increments('id');
		$table->string('title');
		$table->string('read_more');
		$table->text('content');
		$table->unsignedInteger('comment_count');
		$table->string('image');
		$table->text('title_ru');
		$table->text('content_ru');			
		$table->text('read_more_ru');	
		$table->timestamps();
		$table->engine = 'MyISAM';
		$table->softDeletes();
	});
	DB::statement('ALTER TABLE posts ADD FULLTEXT search(title, content)');
}

/**
 * Reverse the migrations.
 *
 * @return void
 */
public function down()
{
	Schema::table('posts', function(Blueprint $table) {
		$table->dropIndex('search');
		$table->drop();
	});
}

}