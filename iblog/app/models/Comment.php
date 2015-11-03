<?php
// file: app/models/Comment.php
class Comment extends Eloquent {
 
    protected $fillable = array('commenter','email','comment','approved','image');

    protected $softDelete = true;

	public static $rulesNotReg = [
            'commenter' => 'required',
            'email'     => 'required | email',
            'comment'   => 'required',
            'captcha'   => 'required | captcha',
            'image'     => 'image|mimes:jpeg,jpg,bmp,png,gif',           
    ];

	public static $rulesReg = [
            'comment'   => 'required',            
            'image'     => 'image|mimes:jpeg,jpg,bmp,png,gif',      
    ];

	public function post()
	{
		return $this->belongsTo('Post');
	}

    public function commentsOnHeadComment()
    {
        return $this->hasMany('Comment');
    }

    public function headComment()
    {
        return $this->belongsTo('Comment');
    }
    
    public function tags()
    {
        return $this->morphToMany('Tag', 'taggable');
    }

	public static function getCommentsOrdered($pagination = 20)
    {
        return Comment::orderBy('id','desc')
                      ->paginate($pagination);
    }

    public function getChildComments()
    {
        return Comment::where('comment_id','=',$this->id)                        
                        ->paginate(100);
    }

    public static function getComments2comments()
    {
        return Comment::where('comment_id','<>',0)
                             ->get();        
    }
    
    public function hasChildComments(){
        $childComment = Comment::where('comment_id','=',$this->id)                        
                        ->get();
        if (!$childComment->isEmpty())
               return true;
        return false;   
    }

	public function getCountCommentsByPost()
    {
        return Comment::where('post_id','=',$this->post->id)
        				->where('approved','=',1)
                        ->count();
    }

    public static function getCommentsLike($searchItem, $pagination = 10)
    {
        $searchItem = '%'.$searchItem.'%';
                
        return Comment::where('commenter','LIKE', $searchItem)
                        ->orWhere('comment','LIKE', $searchItem)                     
                        ->paginate($pagination);
    }

    public function softDelete()
    {
        $post = $this->post;
        $status = $this->approved;
        $this->delete();
        ($status == 1) ? $post->decrement('comment_count') : '';
    }

    public function hardDelete()
    {
        $post = $this->post;
        $status = $this->approved;
        File::delete('public/'.$this->image);
        $this->delete();
        ($status == 1) ? $post->decrement('comment_count') : '';
    }

    public function updateComment($status)
    {
    	$this->approved = $status;
        $this->save();
        $this->post->comment_count = $this->getCountCommentsByPost();                                              
        $this->post->save();
    }

    public function getCommenter()
    {
        if($this->user_id == 0)
             return $this->commenter;
        $user = User::where('id','=',$this->user_id)
                      ->first(); 
        if (isset($user)) return $user->username;
        return trans('messages.Deleted');
    }

    public function getPost()
    {        
        return Comment::getPostRec($this->id);
    }

    public static function getPostRec($cid)
    {
        $parentComment = Comment::where('id','=',$cid)->first();
           
        if($parentComment->post_id > 0)
            return Post::where('id','=', $parentComment->post_id)->first();

        return Comment::getPostRec($parentComment->comment_id);   
    }

    public function addTagOrCreateNew($tag,$user_id = 0)
    {         
        $tagFound = Tag::where('id','=',$tag)->first();

        if (!isset($tagFound)){
            $tagFound = new Tag;
            $tagFound->name = $tag;
            $tagFound->user_id = $user_id;
            $tagFound->save();
        }

        $tagFound->comments()->save($this);        
    }

}