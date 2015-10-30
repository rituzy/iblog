<?php
// file: app/models/Post.php
class Post extends Eloquent {

protected $fillable = array('title','content','title_ru','content_ru','image');

    protected $softDelete = true;

	public static $rules = [
			'title_ru'   => 'required',
      'content_ru' => 'required',
      'title'      => 'required',
      'image'      => 'image|mimes:jpeg,jpg,bmp,png,gif',
    ];
    
	public function comments()
	{
		return $this->hasMany('Comment');
	}

    public function tags()
    {
        return $this->morphToMany('Tag', 'taggable');
    }

	public static function getPostsOrdered($pagination = 10)
    {
        return Post::orderBy('id','desc')
                     ->paginate($pagination);
    }

    public function getComments(){
    	return $this->comments()->where('approved', '=', 1)    	             
    	                        ->get();
    }

    public static function getPostsLike($searchItem, $pagination = 10)
    {
        $searchItem = '%'.$searchItem.'%';
        
        return Post::where('title','LIKE', $searchItem)
                     ->orWhere('content','LIKE', $searchItem)                     
                     ->paginate($pagination);
    }

    public function softDelete(){
        $this->delete();        
    }

    public function hardDelete(){
        $comments = $this->comments()->get();
        foreach ($comments as $comment) {
            $comment->hardDelete();
        }
        File::delete('public/'.$this->image);
        $this->delete();        
    }

    public function addTagOrCreateNew($tag,$user_id = 0)
    {         
      $user_id  = User::where('username','=','admin')->first();
      if (!isset($user_id))
          $user_id = 0;  

      $tagFound = Tag::where('id','=',$tag)->first();

      if (!isset($tagFound)){
          $tagFound = new Tag;
          $tagFound->name = $tag;
          $tagFound->user_id = $user_id;
          $tagFound->save();
      }

      $tagFound->posts()->save($this);        
    }

}