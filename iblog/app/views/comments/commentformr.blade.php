<div id="reply">
    <h2>{{ trans('messages.Leave a Reply on the post'); }}</h2>
    @if(Session::has('success'))
        <div data-alert class="alert-box round">
            {{Session::get('success')}}
            <a href="#" class="close">&times;</a>
        </div>
    @endif
    {{ Form::open(['route'=>['comment.new.reg',$post->id], 'files'=>true, 'id'=>'comment']) }}
        <div class="row">
            <div class="small-7 large-7 column">
                {{ Form::label('comment',Lang::choice('messages.Comments', 1).':') }}
                {{ Form::textarea('comment',Input::old('comment'),['rows'=>5]) }}
            </div>
        </div>
        <div class="row">
            <div class="small-7 large-7 column">
                {{ Form::label('image',trans('messages.Choose an image').':') }}
                {{ Form::file('image') }}
            </div>
            {{ Form::hidden('uid', Auth::user()->id); }}            
        </div>
        <div class="row">
            <div class="small-7 large-7 column">
                {{ Form::label('tag',trans('messages.Choose a tag').':') }}                           
                {{ Form::select('tag',array('default' => trans('messages.Select tag')) + $tag_opt + array('new' => trans('messages.New tag')) )}}
                {{ Form::text('newTag',Input::old('newTag'),['id'=>'newTag']) }}
            </div>
        </div>
        @if($errors->has())
            @foreach($errors->all() as $error)
                <div data-alert class="alert-box warning round">
                    {{$error}}
                    <a href="#" class="close">&times;</a>
                </div>
            @endforeach
        @endif
        
    {{ Form::submit(trans('messages.Submit'),['class'=>'button tiny radius']) }}
    {{ Form::close() }}
</div>
