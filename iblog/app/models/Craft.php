<?php
 
class Craft extends Eloquent
{
    protected $fillable = array('title','title_ru','image','description','description_ru','link');
    
    protected $softDelete = true;

    public static $rules = [
            'title'        => 'required',
            'description'  => 'required',
            //'link'         => 'active_url',
            'image'        => 'image|mimes:jpeg,jpg,bmp,png,gif|max:3000',
            'user_id'      => 'required',            
    ];
    
    public function user(){
        return $this->belongsTo('User');
    }
    
    public function tags()
    {
        return $this->morphToMany('Tag', 'taggable');
    }
    
  	
  	/**
  	* Get crafts ordered 
  	*
  	*/
  	public static function getCraftsOrdered($pagination = 30){
    		return Craft::orderBy('id','desc')->paginate($pagination);
  	}
  	
    public static function getCraftsLike($searchItem, $pagination = 10)
    {
        $searchItem = '%'.$searchItem.'%';
                
        return Craft::where('description','LIKE', $searchItem)
                      ->orWhere('title','LIKE', $searchItem)
                        ->paginate($pagination);
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

        $tagFound->crafts()->save($this);        
    }

    public function getCreatorName(){
      $users = User::getUserOrdered();
      foreach($users as $user)      
        if($user->id == $this->user_id)
          return $user->username;
      return 'noname';
    }

}