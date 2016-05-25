@if(!empty($notFoundPosts))
    <p>{{ trans('messages.TSNFP', ['tag'=>$tag->name] ); }}!</p>
@else
    <h4>{{ trans('messages.TFP', ['tag'=>$tag->name] ); }}:</h4>
    @foreach($posts as $post)
        <article class="post">
            <header class="post-header">
                <h1 class="post-title">
                    {{link_to_route('post.show',(Session::get('lang') === 'ru') ? $post->title_ru : $post->title,$post->id)}}
                </h1>
                <div class="clearfix">
                    <span class="left date">{{explode(' ',$post->created_at)[0]}}</span>
                    <span class="right label">{{$post->comment_count}} {{ trans('messages.comments'); }} </span>
                </div>
            </header>
            <div class="post-content">
                <p>{{$post->read_more.' ...'}}</p>
                <span>{{link_to_route('post.show', trans('messages.RFA'),$post->id)}}
            </div>
            <div class="post-content">
                {{ ($post->image != null)?HTML::image($post->image, $post->title, ['widh'=>'400']):"" }}
            </div>
            <footer class="post-footer">
                <hr>
            </footer>
        </article>
    @endforeach
@endif
@if(!empty($notFoundComments))
    <p>{{ trans('messages.TSNFC', ['tag'=>$tag->name] ); }}!</p>
@else
    <h4>{{ trans('messages.TFC', ['tag'=>$tag->name] ); }}:</h4>
    @foreach($comments as $comment)
        <article class="comment">
            <header class="comment-header">
                <h1 class="comment-title">
                    {{link_to_route('post.show',$comment->getPost()->title,$comment->getPost()->id)}}
                </h1>
                <div class="clearfix">
                    <span class="left date">{{explode(' ',$comment->created_at)[0]}}</span>                    
                    <span class="right label">{{$comment->commenter}} wrote </span>
                </div>
            </header>
            <div class="comment-content">
                <p>{{$comment->comment}}</p>                
            </div>
            <div class="comment-content">
                {{ ($comment->image != null)?HTML::image($comment->image, $comment->comment, ['widh'=>'400']):"" }}
            </div>
            <footer class="comment-footer">
                <hr>
            </footer>
        </article>
    @endforeach    
@endif

@if(!empty($notFoundPhotos))
    <p>{{ trans('messages.TSNFPo', ['tag'=>$tag->name] ); }}!</p>
@else
    <h4>{{ trans('messages.TFPo', ['tag'=>$tag->name] ); }}:</h4>
    @foreach($photos as $photo)
      <article class="comment">            
        @if( Auth::check() && ( Auth::user()->id == $photo->user_id || $photo->album->isAllowedUser(Auth::user()->id) || Auth::user()->hasRole('admin') ) )
          {{ HTML::image($photo->getPhotoImage(),$photo->description,['width'=>'200']) }}
          <div class="comment-content">
            Description: {{ $photo->description }}
          </div>
          <div class="comment-content">
            Album: {{ $photo->getAlbumName() }}
          </div>
        @else  
            <p>{{ trans('messages.TSRPo', ['tag'=>$tag->name] ); }}!</p>
        @endif
      </article>
    @endforeach    
@endif

@if(!empty($notFoundCrafts))
    <p>{{ trans('messages.TSNFCr', ['tag'=>$tag->name] ); }}!</p>
@else
    <h4>{{ trans('messages.TFCr', ['tag'=>$tag->name] ); }}:</h4>
    @foreach($crafts as $craft)
        <article class="craft">
            <header class="craft-header">
                <h1 class="craft-title">
                    {{ (Session::get('lang') === 'ru') ? $craft->title_ru : $craft->title}}
                </h1>
                <div class="clearfix">
                    <span class="left date">{{explode(' ',$craft->created_at)[0]}}</span>                    
                </div>
            </header>
            <div class="craft-content">
                <p>{{ (Session::get('lang') === 'ru') ? $craft->comment_ru : $craft->comment}}</p>                
            </div>
            <div class="craft-content">
                <p>{{$craft->link}}</p>                
            </div>
            <div class="comment-content">
                {{ ($craft->image != null)?HTML::image($craft->image, (Session::get('lang') === 'ru') ? $craft->title_ru : $craft->title, ['widh'=>'400']):"" }}
            </div>
            <footer class="comment-footer">
                <hr>
            </footer>
        </article>
    @endforeach    
@endif

