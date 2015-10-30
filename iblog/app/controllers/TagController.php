    <?php
    //file: app/controllers/TagController.php
     
    class TagController extends BaseController
    {
     
    /* get functions */
    /*
    public function listTag()
    {
        $tags = Tag::getTagsOrdered();
        $this->layout->title = 'Tag listings';
        $this->layout->main = View::make('admin.dashboard')
                                    ->nest('content','tags.list',compact('tags'));
    }
    */
    public function showTaggables(Tag $tag)
    {
        $comments = $tag->getCommentsByTag();
        $posts = $tag->getPostsByTag();
        $photos = $tag->getPhotosByTag();
        $crafts = $tag->getCraftsByTag();
        $tags  = Tag::getTagsOrdered();
        $this->layout->title = trans('messages.SAITW').' '.$tag->name;
        $users = User::all();

        if ($posts->isEmpty())
            $notFoundPosts = true;
        else
            $notFoundPosts = false;

        if ($comments->isEmpty()) 
            $notFoundComments = true;
        else
            $notFoundComments = false;

        if ($photos->isEmpty())
            $notFoundPhotos = true;
        else
            $notFoundPhotos = false;

        if ($crafts->isEmpty())
            $notFoundCrafts = true;
        else
            $notFoundCrafts = false;

        $recentPosts = Post::getPostsOrdered();        
        $this->layout->main = View::make('home',array('recentPosts'=>$recentPosts,'allTags'=>$tags))
                                    ->nest('content', 'index_tags',
                                     compact('tag','comments','posts','photos','users','crafts',
                                        'notFoundPosts','notFoundComments','notFoundPhotos','notFoundCrafts') );
    }
     
    public function listTag()
    {
        $tag_opt = Tag::getTagOptions();
        $tags    = Tag::getTagsOrdered();
        $users   = User::all();        
        $this->layout->title = trans('messages.Tag listings');
        $this->layout->main = View::make('admin.dashboard')
                                    ->nest('content','tags.list',compact('tags','users','tag_opt'));
    }     
    
    public function editTag(Tag $tag)
    {
        $this->layout->title = trans('messages.Edit').' '.Lang::choice('messages.Tags', 1);
        $this->layout->main = View::make('admin.dashboard')
                                    ->nest('content', 'tags.edit', compact('tag'));
    }
     
    public function deleteTag(Tag $tag)
    {        
        $tag->delete();
        return Redirect::route('tag.list')
                         ->with('success', Lang::choice('messages.Tags', 1).' '.trans('messages.is deleted'));
    }
    
    /* post functions */
    public function updateTag(Tag $tag)
    {
        $inputs = [
            'name'   => Input::get('name'),            
        ];
       
        $valid = Validator::make($inputs, Tag::$rules);
        if ($valid->passes())
        {
            $tag->name   = $inputs['name'];

            if(count($tag->getDirty()) > 0)
            {
                $tag->save();
                return Redirect::back()->with('success', Lang::choice('messages.Tags', 1).' '.trans('messages.is updated'));
            }
            else
                return Redirect::back()->with('success',trans('messages.Nothing to update') );
        }
        else
            return Redirect::back()->withErrors($valid)->withInput();
    }

    public function mergeTag()
    {   
        $allTags    = Tag::getIDs();
        $tagsMerge  = array();
        $tagTomergeWith  = Input::get('mergeTag');

        if ($tagTomergeWith == 'default')
            return Redirect::back()->withErrors( trans('messages.SATTMW') ) ;

        foreach ($allTags as $tagMerge){
            if (Input::get($tagMerge) == 1)
                array_push($tagsMerge,$tagMerge);            
        }

        if ( array_search($tagTomergeWith, $tagsMerge) !== false ) 
            return Redirect::back()->withErrors( trans('messages.CMTTWI') );
        
        if ( ( count($tagsMerge) ) == 0 )
            return Redirect::back()->withErrors( trans('messages.CNM0T') );

        Tag::merge($tagsMerge, $tagTomergeWith);
        return Redirect::back()->with('success', trans('messages.TTAM') );

    }
    
     
}
