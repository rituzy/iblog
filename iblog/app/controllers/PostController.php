    <?php
    //file: app/controllers/PostsController.php
     
    class PostController extends BaseController
    {
     
    /* get functions */
    public function listPost()
    {
        $posts = Post::getPostsOrdered();
        $this->layout->title = trans('messages.Post listings');
        $this->layout->main = View::make('admin.dashboard')
                                    ->nest('content','posts.list',compact('posts'));
    }

    public function showPost(Post $post)
    {
        $comments = $post->getComments();
        $this->layout->title = $post->title;
        $users = User::all();
        $comments2comments = Comment::getComments2comments();
        $recentPosts = Post::getPostsOrdered();
        $tag_opt     = Tag::getTagOptions();
        $tags        = Tag::getTagsOrdered();
        //$this->lcfirst(str)ayout->main = View::make('home')->nest('content', 'posts.single', compact('post', 'comments'));
        $this->layout->main = View::make('home',array('recentPosts'=>$recentPosts, 'allTags'=>$tags))
                                    ->nest('content', 'posts.single',
                                     compact('post', 'comments','users',
                                        'comments2comments', 'tag_opt'));
    }
     
    public function newPost()
    {
        $this->layout->title = trans('messages.New').' '.Lang::choice('messages.Posts', 1);
        $tag_opt  = Tag::getTagOptions();
        $this->layout->main = View::make('admin.dashboard')
                                    ->nest('content', 'posts.new', compact('tag_opt'));
     }
     
    public function editPost(Post $post)
    {
        $this->layout->title = trans('messages.Edit').' '.Lang::choice('messages.Posts', 1);
        $tag_opt  = Tag::getTagOptions();
        $this->layout->main = View::make('admin.dashboard')
                                    ->nest('content', 'posts.edit', compact('post','tag_opt'));
    }
     
    public function deletePost(Post $post)
    {        
        $post->softDelete();
        return Redirect::route('post.list')
                         ->with('success', Lang::choice('messages.Posts', 1).' '.trans('messages.is deleted'));
    }
     
    /* post functions */
    public function savePost()
    {
        $inputs = [
            'title'      => Input::get('title'),
            'content'    => Input::get('content'),
            'title_ru'   => Input::get('title_ru'),
            'content_ru' => Input::get('content_ru'),
            'image'      => Input::file('image'),
            'tag'        => Input::get('tag'),
        ];
        
        $valid = Validator::make($inputs, Post::$rules);
        if ($valid->passes())
        {            
            $post = new Post;
            $post->title      = $inputs['title'];
            $post->content    = $inputs['content'];
            $post->title_ru   = $inputs['title_ru'];
            $post->content_ru = $inputs['content_ru'];
            $tag              = $inputs['tag'];

            if (isset($inputs['image'])){ 
                $image = $inputs['image'];
                list($width, $height) = getimagesize($image);
                $ratio = $height/$width;
                $filename = date('Y-m-d-H:i:s')."-".$image->getClientOriginalName();
                $width = ($width>600)?600:$width;
                $height = ($height>600)? $width*$ratio :$height;
                Image::make($image->getRealPath())->resize($width,$height)
                       ->save(public_path().'/img/pncpictures/'.$filename);
                $post->image = 'img/pncpictures/'.$filename;
            }

            if ($tag != 'default')
                $post->addTagOrCreateNew($tag);

            $post->comment_count = 0;
            $post->read_more = (strlen($post->content) > 120) ? substr($post->content, 0, 120) : $post->content;
            $post->read_more_ru = (strlen($post->content_ru) > 120) ? substr($post->content_ru, 0, 120) : $post->content_ru;
            $post->save();            
            return Redirect::route('post.new')->with('success', Lang::choice('messages.Posts', 1).' '.trans('messages.is saved'));
        }
        else
            return Redirect::back()->withErrors($valid)->withInput();
    }
     
    public function updatePost(Post $post)
    {
        $inputs = [
            'title'      => Input::get('title'),
            'content'    => Input::get('content'),
            'title_ru'   => Input::get('title_ru'),
            'content_ru' => Input::get('content_ru'),            
            'image'      => Input::file('image'),
            'tag'        => Input::get('tag'),
        ];
       
        $valid = Validator::make($inputs, Post::$rules);
        if ($valid->passes())
        {
            $post->title      = $inputs['title'];
            $post->content    = $inputs['content'];
            $post->title_ru   = $inputs['title_ru'];
            $post->content_ru = $inputs['content_ru'];
            $tag              = $inputs['tag'];

            if (isset($inputs['image'])){ 
                $image = $inputs['image'];
                list($width, $height) = getimagesize($image);
                $ratio = $height/$width;
                $filename = date('Y-m-d-H:i:s')."-".$image->getClientOriginalName();
                $width = ($width>600)?600:$width;
                $height = ($height>600)? $width*$ratio :$height;
                Image::make($image->getRealPath())->resize($width,$height)
                       ->save(public_path().'/img/pncpictures/'.$filename);
                $post->image = 'img/pncpictures/'.$filename;
            }
 
            if ($tag != 'default')
                $post->addTagOrCreateNew($tag);
           
            $post->read_more = (strlen($post->content) > 120) ? substr($post->content, 0, 120) : $post->content;
            $post->read_more_ru = (strlen($post->content_ru) > 120) ? substr($post->content_ru, 0, 120) : $post->content_ru;

            if(count($post->getDirty()) > 0) /* avoiding resubmission of same content */
            {
                $post->save();
                return Redirect::back()->with('success', Lang::choice('messages.Posts', 1).' '.trans('messages.is updated'));
            }
            else
                return Redirect::back()->with('success',trans('messages.Nothing to update!') );
        }
        else
            return Redirect::back()->withErrors($valid)->withInput();
    }
     
}
