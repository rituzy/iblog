<?php
 
class Tag extends Eloquent
{
    protected $fillable = array('name','user_id');

    protected $softDelete = true;

    public static $rules = [            
        'name' => 'required|unique:tags|min:3|max:12',            
    ];

    public function posts()
    {
        return $this->morphedByMany('Post', 'taggable');
    }

    public function comments()
    {
        return $this->morphedByMany('Comment', 'taggable');
    }

    public function albums()
    {
        return $this->morphedByMany('Album', 'taggable');
    }

    public function photos()
    {
        return $this->morphedByMany('Photo', 'taggable');
    }

    public function crafts()
    {
        return $this->morphedByMany('Craft', 'taggable');
    }

    public static function getTagsOrdered($pagination = 10)
    {
        return Tag::orderBy('id','desc')
                     ->paginate($pagination);
    }

    public static function getTagOptions()
    {
        return Tag::orderBy('id','desc')->lists('name','id');
    }

    public static function getTagByName($name)
    {
        if (empty($name)) return null;
        return Tag::where('name','=',$name);                      
    }

    public function getCommentsByTag()
    {
        $tag = Tag::with('comments')->find($this->id);
        $relations = $tag->getRelations();
        $comments = $relations['comments'];
        return $comments;
    }

    public function getPostsByTag()
    {
        $tag = Tag::with('posts')->find($this->id);
        $relations = $tag->getRelations();
        $posts = $relations['posts'];
        return $posts;
    }

    public function getPhotosByTag()
    {        
        $tag = Tag::with('photos')->find($this->id);
        $relations = $tag->getRelations();
        $photos = $relations['photos'];
        return $photos;
    }

    public function getCraftsByTag()
    {        
        $tag = Tag::with('crafts')->find($this->id);
        $relations = $tag->getRelations();
        $crafts = $relations['crafts'];
        return $crafts;
    }

    public static function getIDs()
    {
        return Tag::lists('id');
    }

    public static function getTagByIDs($tm)
    {
        return Tag::whereIn('id',$tm);                        
    }

    public static function merge($tagsMerge, $tagTomergeWith)
    {   
        DB::table('taggables')
            ->whereIn('tag_id',$tagsMerge)
            ->update([ 'tag_id' => $tagTomergeWith ]);

        Tag::destroy($tagsMerge);
    }

}