{{ Form::open(['url' => 'search','method'=>'get']) }}
    <div class="row">
        <div class="small-8 large-8 column">
            {{ Form::text('s',Input::old('username'),[ 'placeholder'=>trans('messages.Search blog') ]) }}
        </div>
        {{ Form::submit(trans('messages.Search'),['class'=>'button tiny radius']) }}
    </div>
{{ Form::close() }}
<div>
    <h3>{{ trans('messages.Recent Posts'); }}</h3>
    <ul>
        @foreach($recentPosts as $post) 
            <li>{{link_to_route('post.show',(Session::get('lang') === 'ru') ? $post->title_ru : $post->title,$post->id)}}</li>
        @endforeach
    </ul>
</div>
<div>
    <h3>{{ Lang::choice('messages.Tags', 2) ; }}</h3>    
        @foreach($allTags as $tag) 
            {{link_to_route('tag.show',$tag->name,$tag->id)}}
        @endforeach    
</div>