<?php
/* Model Bindings */
Route::model('post','Post');
Route::model('comment','Comment');
Route::model('user','User');
Route::model('role','Role');
Route::model('album','Album');
Route::model('photo','Photo');
Route::model('tag','Tag');
Route::model('craft','Craft');
Route::model('worker','Worker');
Route::model('duty','Duty');
Route::model('card','Card');
Route::model('todo','Todo');

/* Routes for all */
//Route::get('/parse/site',['as' => 'parse.site','uses' => 'BlogController@parseSite']);
Route::get('/post/{post}/show',['as' => 'post.show','uses' => 'PostController@showPost']);
Route::get('/tag/{tag}/show',['as' => 'tag.show','uses' => 'TagController@showTaggables']);
Route::get('/comment/{comment}/show',['as' => 'comment.show.all','uses' =>'CommentController@showCommentAll']);
Route::get('/crafts',['as' => 'crafts.show','uses' => 'BlogController@showCrafts']);
Route::get('/duty/list_fill',['as' => 'duty.list_fill','uses' => 'DutyController@listDutiesFill']);
Route::get('/duty/list_upd',['as' => 'duty.list_upd','uses' => 'DutyController@listDutiesUpd']);
Route::get('/card/list',['as' => 'card.list','uses' => 'CardController@listCards']);
Route::get('/language/{lang}',['as' => 'language.select','uses' => 'LanguageController@select']);

Route::post('/post/{post}/comment',['as' => 'comment.new.not.reg','uses' =>'CommentController@newCommentNotReg']);
Route::post('/comment/{comment}/comment',['as' => 'comment.comment.new.not.reg','uses' =>'CommentController@newCommentOnCommentNotReg']);
Route::post('/vkLogin', ['as' => 'vkLogin', 'uses' => 'Admin\AdminController@postVKLogin']);

/* Admin routes */
Route::group(['prefix' => 'admin','before'=>'auth|role_admin'],function()
{
	//get routes
	Route::get('dash-board',
		/*function()
	{
		$layout = View::make('master');
		$layout->title = 'DashBoard';
		$layout->main = View::make('dash')->with('content','Hi admin, Welcome to Dashboard!');
		return $layout;
	}*/

	['as' => 'admin.dash-board','uses' => 'BlogController@getDash']);
	Route::get('/post/list',['as' => 'post.list','uses' => 'PostController@listPost']);
	Route::get('/post/new',['as' => 'post.new','uses' => 'PostController@newPost']);
	Route::get('/post/{post}/edit',['as' => 'post.edit','uses' => 'PostController@editPost']);
	Route::get('/post/{post}/delete',['as' => 'post.delete','uses' => 'PostController@deletePost']);
	Route::get('/comment/list',['as' => 'comment.list','uses' => 'CommentController@listComment']);
	Route::get('/comment/{comment}/show',['as' => 'comment.show','uses' => 'CommentController@showComment']);
	Route::get('/comment/{comment}/delete',['as' => 'comment.delete','uses' => 'CommentController@deleteComment']);
	Route::get('/user_list',['as' => 'user.list','uses' => 'AdminController@listUser']);
	Route::get('/{user}/delete',['as' => 'user.delete.adm','uses' => 'AdminController@deleteUser']);
	Route::get('/{user}/show',['as' => 'user.show.adm','uses' => 'AdminController@showUser']);
  Route::get('/{user}/edit',['as' => 'user.edit.adm','uses' => 'AdminController@editUser']);
  Route::get('/role_list',['as' => 'role.list','uses' => 'RoleController@listRole']);
  Route::get('/role/new',['as' => 'role.new','uses' => 'RoleController@newRole']);
  Route::get('/role/{role}/edit',['as' => 'role.edit','uses' => 'RoleController@editRole']);
  Route::get('/role/{role}/delete',['as' => 'role.delete','uses' => 'RoleController@deleteRole']);
  Route::get('/tag/list',['as' => 'tag.list','uses' => 'TagController@listTag']);
  Route::get('/tag/{tag}/edit',['as' => 'tag.edit','uses' => 'TagController@editTag']);
  Route::get('/tag/{tag}/delete',['as' => 'tag.delete','uses' => 'TagController@deleteTag']);
  Route::get('/craft_list',['as' => 'craft.list','uses' => 'CraftController@listCrafts']);
  Route::get('/craft/new',['as' => 'craft.new','uses' => 'CraftController@newCraft']);
  Route::get('/craft/{craft}/edit',['as' => 'craft.edit','uses' => 'CraftController@editCraft']);
  Route::get('/craft/{craft}/delete',['as' => 'craft.delete','uses' => 'CraftController@deleteCraft']);
	Route::get('/craft/{craft}/view',['as' => 'craft.view','uses' => 'CraftController@viewCraft']);
	Route::get('/duty/list_fill',['as' => 'duty.list_fill','uses' => 'DutyController@listDutiesFill']);
	Route::get('/duty/list_upd',['as' => 'duty.list_upd','uses' => 'DutyController@listDutiesUpd']);
  Route::get('/duty/new',['as' => 'duty.new','uses' => 'DutyController@newDuty']);
  Route::get('/duty/{duty}/edit',['as' => 'duty.edit','uses' => 'DutyController@editDuty']);
  Route::get('/duty/{duty}/delete',['as' => 'duty.delete','uses' => 'DutyController@deleteDuty']);
	Route::get('/card/list',['as' => 'card.list','uses' => 'CardController@listCards']);
  Route::get('/card/new',['as' => 'card.new','uses' => 'CardController@newCard']);
  Route::get('/card/{card}/edit',['as' => 'card.edit','uses' => 'CardController@editCard']);
  Route::get('/card/{card}/delete',['as' => 'card.delete','uses' => 'CardController@deleteCard']);

	//post routes
	Route::post('/post/save',['as' => 'post.save','uses' => 'PostController@savePost']);
	Route::post('/post/{post}/update',['as' => 'post.update','uses' => 'PostController@updatePost']);
	Route::post('/comment/{comment}/update',['as' => 'comment.update','uses' => 'CommentController@updateComment']);
  Route::post('/role/save',['as' => 'role.save','uses' => 'RoleController@saveRole']);
	Route::post('/role/{role}/update',['as' => 'role.update','uses' => 'RoleController@updateRole']);
	Route::post('/user/{user}/updateRole',['as' => 'userRole.update','uses' => 'UserController@updateUserRole']);
	Route::post('/tag/{tag}/update',['as' => 'tag.update','uses' => 'TagController@updateTag']);
  Route::post('/tag/merge',['as' => 'tag.merge','uses' => 'TagController@mergeTag']);
  Route::post('/craft/save',['as' => 'craft.save','uses' => 'CraftController@saveCraft']);
	Route::post('/craft/{craft}/update',['as' => 'craft.update','uses' => 'CraftController@updateCraft']);
	Route::post('/duty/save',['as' => 'duty.save','uses' => 'DutyController@saveDuty']);
	Route::post('/duty/{duty}/update',['as' => 'duty.update','uses' => 'DutyController@updateDuty']);
	Route::post('/card/save',['as' => 'card.save','uses' => 'CardController@saveCard']);
	Route::post('/card/{card}/update',['as' => 'card.update','uses' => 'CardController@updateCard']);
});

Route::get('/user/new',['as' => 'user.new','uses' => 'StandardUserController@newUser']);
Route::post('/user/save',['as' => 'user.save','uses' => 'StandardUserController@saveUser']);
Route::get('password/reset', ['as' => 'password.remind','uses' => 'StandardUserController@remind']);
Route::post('password/reset', ['as' => 'password.request','uses' => 'StandardUserController@request']);

/*Routes for registered users*/
Route::group(['prefix' => 'user','before'=>'auth'],function()
{
	//get routes
	Route::get('/{user}/edit',['as' => 'user.edit','uses' => 'StandardUserController@editUser']);
	Route::get('/{user}/delete',['as' => 'user.delete','uses' => 'StandardUserController@deleteUser']);
	Route::get('/{user}/show',['as' => 'user.show','uses' => 'StandardUserController@showUser']);
	Route::get('/album_list',['as' => 'album.list','uses' => 'AlbumController@listAlbums']);
  Route::get('/album/new',['as' => 'album.new','uses' => 'AlbumController@newAlbum']);
  Route::get('/album/{album}/edit',['as' => 'album.edit','uses' => 'AlbumController@editAlbum']);
  Route::get('/album/{album}/delete',['as' => 'album.delete','uses' => 'AlbumController@deleteAlbum']);
  Route::get('/photo_list',['as' => 'photo.list','uses' => 'PhotoController@listPhotos']);
  Route::get('/photo/new',['as' => 'photo.new','uses' => 'PhotoController@newPhoto']);
  Route::get('/photo/{photo}/edit',['as' => 'photo.edit','uses' => 'PhotoController@editPhoto']);
  Route::get('/photo/{photo}/delete',['as' => 'photo.delete','uses' => 'PhotoController@deletePhoto']);
  Route::get('/todo_list',['as' => 'todo.list','uses' => 'TodoController@listTodo']);
  Route::get('/todo/new',['as' => 'todo.new','uses' => 'TodoController@newTodo']);
  Route::get('/todo/{todo}/edit',['as' => 'todo.edit','uses' => 'TodoController@editTodo']);
  Route::get('/todo/{todo}/delete',['as' => 'todo.delete','uses' => 'TodoController@deleteTodo']);

	//post routes
	Route::post('/{user}/update',['as' => 'user.update','uses' => 'SingleUserController@updateUser']);
	Route::post('/album/save',['as' => 'album.save','uses' => 'AlbumController@saveAlbum']);
	Route::post('/album/{album}/update',['as' => 'album.update','uses' => 'AlbumController@updateAlbum']);
	Route::post('/photo/save',['as' => 'photo.save','uses' => 'PhotoController@savePhoto']);
	Route::post('/photo/{photo}/update',['as' => 'photo.update','uses' => 'PhotoController@updatePhoto']);
	Route::post('/photo_list_by_album',['as' => 'photo.list.album','uses' => 'PhotoController@listPhotosByAlbum']);
  Route::post('/photo_list_by_user',['as' => 'photo.list.user','uses' => 'PhotoController@listPhotosByUser']);
  Route::post('/photo_list_by_date',['as' => 'photo.list.date','uses' => 'PhotoController@listPhotosByDate']);
  Route::post('/post/{post}/comment',['as' => 'comment.new.reg','uses' =>'CommentController@newCommentReg']);
  Route::post('/comment/{comment}/comment',['as' => 'comment.comment.new.reg','uses' =>'CommentController@newCommentOnCommentReg']);
  Route::post('/album/{album}/updateRole',['as' => 'albumRole.update','uses' => 'AlbumController@updateAlbumRole']);
  Route::post('/todo/save',['as' => 'todo.save','uses' => 'TodoController@saveTodo']);
	Route::post('/todo/{todo}/update',['as' => 'todo.update','uses' => 'TodoController@updateTodo']);
	Route::post('/todo_filtered',['as' => 'todo.list.filtered','uses' => 'TodoController@listFiltered']);
});

Route::group(['prefix' => 'photos'],function()
{
	Route::get('/',['as' => 'photos.show','uses' => 'BlogController@showPhotos']);
	Route::post('/album',['as' => 'photos.show.album','uses' => 'BlogController@showPhotosByAlbum']);
	Route::post('/user',['as' => 'photos.show.user','uses' => 'BlogController@showPhotosByUser']);
	Route::post('/date',['as' => 'photos.show.date','uses' => 'BlogController@showPhotosByDate']);
});

Route::controller('admin','Admin\AdminController');
Route::controller('/','BlogController');
