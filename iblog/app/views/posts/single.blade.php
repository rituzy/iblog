<article class="post">
    <header class="post-header">
        <h1 class="post-title">
            {{ (Session::get('lang') === 'ru') ? $post->title_ru : $post->title }}
        </h1>
        <div class="clearfix">
            <span class="left date">{{explode(' ',$post->created_at)[0]}}</span>
            <span class="right label">{{HTML::link('#reply',trans('messages.Reply'),['style'=>'color:inherit'])}} </span>
        </div>
    </header>
    <div class="post-content">
        {{ ($post->image != null)?HTML::image($post->image, (Session::get('lang') === 'ru') ? $post->title_ru : $post->title, ['widh'=>'400']):"" }}
    </div>
    <div class="post-content">
        <p>{{ (Session::get('lang') === 'ru') ? $post->content_ru : $post->content }}</p>
    </div>
    <footer class="post-footer">
        <hr>
    </footer>
</article>
<a href="#bottomPostForm">{{ trans('messages.Reply to this post'); }}</a>
<section class="comments">    
    @if(!$comments->isEmpty())
        <h2>{{ trans('messages.Comments on').' '; }} {{ (Session::get('lang') === 'ru') ? $post->title_ru : $post->title }}</h2>
        <ul>
            @foreach($comments as $comment)
                <li>
                    <article>
                        <header>
                            <div class="clearfix">
                                <span class="right date">{{explode(' ',$comment->created_at)[0]}}</span>                                
                                <span class="left commenter"> {{ link_to_route('post.show',$comment->getCommenter(),$post->id) }}</span>                                
                            </div>
                        </header>
                        <div class="comment-content">
                            {{ ( preg_match('/pncpictures/',$comment->image) == 1) ? HTML::image($comment->image, $comment->comment, ['widh'=>'400']) : '' }}
                        </div>
                        <div class="comment-content">
                            <p>{{{$comment->comment}}}</p>
                        </div>
                        <div>
                            {{ link_to_route( 'comment.show.all', trans('messages.Comment to this comment'), $comment->id ) }}                          
                        </div>
                        <footer>
                            @if( $comment->hasChildComments() ) 
                               <input class="toggle-box" id="{{$comment->id.$comment->created_at}}" type="checkbox" >
                               <label for="{{$comment->id.$comment->created_at}}">{{ trans('messages.Show comments on this comment') }}</label>
                               <div>
                                   {{ trans('messages.Comments on this comment').':' }}
                                   @include('comments.single')                                    
                               </div>                         
                            @endif
                            <hr>
                        </footer>
                    </article>
                </li>
            @endforeach
        </ul>
    @else
        <h2>{{ trans('messages.No Comments on').' ' }} {{ (Session::get('lang') === 'ru') ? $post->title_ru : $post->title }}</h2>
    @endif        
    @include('comments.postComment')
    <a name="bottomPostForm"></a>
</section>
