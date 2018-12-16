<?php
//file: app/controllers/CommentsController.php
 
class CommentController extends BaseController {
     
    /* get functions */
    public function listComment()
    {
        $comments = Comment::getCommentsOrdered();        
        $users    = User::All();
        $this->layout->title = trans('messages.Comment Listings');
        $this->layout->main = View::make('admin.dashboard')
                                    ->nest('content','comments.list',compact('comments','users'));
    }
     
    public function showComment(Comment $comment)
    {
        if(Request::ajax())
            return View::make('comments.show',compact('comment'));
    // handle non-ajax calls here
    //else{}
    }
     
    public function deleteComment(Comment $comment)
    {
        $comment->softDelete();
        return Redirect::back()->with('success',Lang::choice('messages.Comments', 1).' '.trans('is deleted'));
    }
     
    public function showCommentAll(Comment $comment)
    {        
        $this->layout->title = trans('messages.COCC');
        $users       = User::all();
        $tag_opt     = Tag::getTagOptions();
        $comments2comments = Comment::getComments2comments();
        $recentPosts = Post::getPostsOrdered();
        $tags        = Tag::getTagsOrdered();

        $this->layout->main = View::make('home',array('recentPosts'=>$recentPosts,'allTags'=>$tags))
                                    ->nest('content', 'comments.singleComment4c', 
                                     compact('comment', 'users','comments2comments',
                                        'tag_opt'));
    }
    /* post functions */
     
    public function updateComment(Comment $comment)
    {
        $status = Input::get('status');
        $comment->updateComment($status);
        //return Redirect::back()->with('success','Comment '. (($comment->approved === 'yes') ? 'Approved' : 'Disapproved'));
        return Redirect::back()
                         ->with('success','Comment '. 
                            (($comment->approved == 1) ? 'Approved' : 'Disapproved'));
    }

    public function newCommentNotReg(Post $post)
    {
        $inputs = [
            'commenter' => Input::get('commenter'),
            'email'     => Input::get('email'),
            'comment'   => Input::get('comment'),
            'captcha'   => Input::get('captcha'),
            'image'     => Input::file('image'),
            'name'      => Input::get('tag'),            
        ];
        
        $attributeNames = ['name'=>'Tag name'];
        $valid = Validator::make($inputs, Comment::$rulesNotReg);
        $valid -> setAttributeNames($attributeNames);
        $valid -> sometimes('name','unique:tags|min:3|max:12',function($inputs){
            return !is_numeric( $inputs['name'] );
        });

        if($valid->passes())
        {
            $comment = new Comment;
            //uncomment the string below to use comment checking by administrator 
            $comment->approved = 0;//'no';            
            $comment->commenter = $inputs['commenter'];
            $comment->email     = $inputs['email'];
            $comment->comment   = $inputs['comment'];
            $comment->user_id   = 0;
            $tag                = $inputs['name'];

            $image = $inputs['image'];
            if (isset($image)) {
                list($width, $height) = getimagesize($image);
                $ratio = $height/$width;
                $filename = date('Y-m-d-H:i:s')."-".$image->getClientOriginalName();
                $width = ($width>600)?600:$width;
                $height = ($height>600)? $width*$ratio :$height;
                Image::make($image->getRealPath())->resize($width,$height)
                       ->save(public_path().'/img/pncpictures/'.$filename);
                $comment->image = 'img/pncpictures/'.$filename;
            } else
                $comment->image = '';
           
            if ($tag != 'default')
                $comment->addTagOrCreateNew($tag);

            $post->comments()->save($comment);
            //autoapproval of comment
            //$comment->updateComment(1);
            /* redirect back to the form portion of the page */
            return Redirect::to(URL::previous().'#reply')
            ->with('success','Comment has been submitted and waiting for approval!');
            //->with('success',trans('messages.CHBS') );
        }
        else
        {
            return Redirect::to(URL::previous().'#reply')->withErrors($valid)->withInput();
        }
    }

    public function newCommentReg(Post $post)
    {
        $inputs = [
            'user_id'   => Input::get('uid'),
            'comment'   => Input::get('comment'),
            'image'     => Input::file('image'),
            'name'      => Input::get('tag'),
        ];
   
        $attributeNames = ['name'=>'Tag name'];
        $valid = Validator::make($inputs, Comment::$rulesReg);
        $valid -> setAttributeNames($attributeNames);
        $valid -> sometimes('name','unique:tags|min:3|max:12',function($inputs){
            return !is_numeric( $inputs['name'] );
        });
          
        if($valid->passes())
        {
            $comment = new Comment;
            //uncomment the string below to use comment checking by administrator 
            $comment->approved = 0;//'no';
            $comment->commenter = '';
            $comment->email     = '';
            $comment->user_id   = $inputs['user_id'];
            $comment->comment   = $inputs['comment'];
            $tag                = $inputs['name'];
            
            $image = $inputs['image'];
            if (isset($image)) {
                list($width, $height) = getimagesize($image);
                $ratio = $height/$width;
                $filename = date('Y-m-d-H:i:s')."-".$image->getClientOriginalName();
                $width = ($width>600)?600:$width;
                $height = ($height>600)? $width*$ratio :$height;
                Image::make($image->getRealPath())->resize($width,$height)
                       ->save(public_path().'/img/pncpictures/'.$filename);
                $comment->image = 'img/pncpictures/'.$filename;
            } else
                $comment->image = '';

            if ($tag != 'default')
                $comment->addTagOrCreateNew($tag, $inputs['user_id']);

            $post->comments()->save($comment);
            //  autoaproval of comment
            //$comment->updateComment(1);
            /* redirect back to the form portion of the page */
            return Redirect::to(URL::previous().'#reply')
            ->with('success','Comment has been submitted and waiting for approval!');
            //->with('success',trans('messages.CHBS'));
        }
        else
        {
            return Redirect::to(URL::previous().'#reply')->withErrors($valid)->withInput();
        }
    }

    public function newCommentOnCommentNotReg(Comment $headComment)
    {
        $inputs = [
            'commenter' => Input::get('commenter'),
            'email'     => Input::get('email'),
            'comment'   => Input::get('comment'),
            'captcha'   => Input::get('captcha'),
            'image'     => Input::file('image'),
            'name'      => Input::get('tag'),
        ];
        
        $attributeNames = ['name'=>'Tag name'];
        $valid = Validator::make($inputs, Comment::$rulesNotReg);
        $valid -> setAttributeNames($attributeNames);
        $valid -> sometimes('name','unique:tags|min:3|max:12',function($inputs){
            return !is_numeric( $inputs['name'] );
        });
        
        if($valid->passes())
        {
            $comment = new Comment;
            //uncomment the string below to use comment checking by administrator 
            $comment->approved = 0;//'no';            
            $comment->commenter = $inputs['commenter'];
            $comment->email     = $inputs['email'];
            $comment->comment   = $inputs['comment'];
            $comment->user_id   = 0;
            $tag                = $inputs['name'];
            
            $image = $inputs['image'];
            if (isset($image)) {
                list($width, $height) = getimagesize($image);
                $ratio = $height/$width;
                $filename = date('Y-m-d-H:i:s')."-".$image->getClientOriginalName();
                $width = ($width>600)?600:$width;
                $height = ($height>600)? $width*$ratio :$height;
                Image::make($image->getRealPath())->resize($width,$height)
                       ->save(public_path().'/img/pncpictures/'.$filename);
                $comment->image = 'img/pncpictures/'.$filename;
            } else
                $comment->image = '';

            if ($tag != 'default')
                $comment->addTagOrCreateNew($tag);
            // autoapproval of comment 
            //$comment->approved = 1;
            $headComment->commentsOnHeadComment()->save($comment);
            /* redirect back to the form portion of the page */
            return Redirect::to(URL::previous().'#reply')
            ->with('success','Comment has been submitted and waiting for approval!');
            //->with('success',trans('messages.CHBS'));
        }
        else
        {
            return Redirect::to(URL::previous().'#reply')->withErrors($valid)->withInput();
        }
    }

    public function newCommentOnCommentReg(Comment $headComment)
    {
        $inputs = [
            'user_id'   => Input::get('uid'),
            'comment'   => Input::get('comment'),
            'image'     => Input::file('image'),
            'name'      => Input::get('tag'),
        ];
        
        $attributeNames = ['name'=>'Tag name'];
        $valid = Validator::make($inputs, Comment::$rulesReg);
        $valid -> setAttributeNames($attributeNames);
        $valid -> sometimes('name','unique:tags|min:3|max:12',function($inputs){
            return !is_numeric( $inputs['name'] );
        });

        if($valid->passes())
        {
            $comment = new Comment;
            //uncomment the string below to use comment checking by administrator 
            $comment->approved = 0;//'no';
            $comment->commenter = '';
            $comment->email = '';
            $comment->user_id = $inputs['user_id'];
            $comment->comment = $inputs['comment'];
            $tag              = $inputs['name'];
            
            $image = $inputs['image'];
            if (isset($image)) {
                list($width, $height) = getimagesize($image);
                $ratio = $height/$width;
                $filename = date('Y-m-d-H:i:s')."-".$image->getClientOriginalName();
                $width = ($width>600)?600:$width;
                $height = ($height>600)? $width*$ratio :$height;
                Image::make($image->getRealPath())->resize($width,$height)
                       ->save(public_path().'/img/pncpictures/'.$filename);
                $comment->image = 'img/pncpictures/'.$filename;
            } else
                $comment->image = '';

            if ($tag != 'default')
                $comment->addTagOrCreateNew($tag,$inputs['user_id']);
            // autoaproval of comment
            // $comment->approved = 1;
            $headComment->commentsOnHeadComment()->save($comment);
            /* redirect back to the form portion of the page */
            return Redirect::to(URL::previous().'#reply')
            ->with('success','Comment has been submitted and waiting for approval!');
            //->with('success',trans('messages.CHBS'));
        }
        else
        {
            return Redirect::to(URL::previous().'#reply')->withErrors($valid)->withInput();
        }
    }

}
