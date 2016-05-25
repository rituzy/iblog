@if(!empty($notFound))
    <p>{{ trans('messages.SNF'); }}</p>
@else
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
                <p>{{ (Session::get('lang') === 'ru') ? $post->read_more_ru : $post->read_more.' ...'}}</p>
                <span>{{link_to_route('post.show',trans('messages.RFA'),$post->id)}}
            </div>
            <div class="post-content">
                {{ ($post->image != null)?HTML::image($post->image, (Session::get('lang') === 'ru') ? $post->title_ru : $post->title, ['widh'=>'400']):"" }}
            </div>
            <footer class="post-footer">
                <hr>
            </footer>
        </article>
    @endforeach
    {{$posts->links()}}
@endif
