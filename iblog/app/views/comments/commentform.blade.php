<div id="reply">
    <h2>{{ trans('messages.Leave a Reply on').' '.Lang::choice('messages.Posts', 1); }}</h2>
    @if(Session::has('success'))
        <div data-alert class="alert-box round">
            {{Session::get('success')}}
            <a href="#" class="close">&times;</a>
        </div>
    @endif
    {{ Form::open(['route'=>['comment.new',$post->id], 'files'=>true]) }}
        <div class="row">
            <div class="small-5 large-5 column">
                {{ Form::label('commenter',trans('messages.Name').':' ) }}
                {{ Form::text('commenter',Input::old('commenter')) }}
            </div>
        </div>
        <div class="row">
            <div class="small-5 large-5 column">
                {{ Form::label('email',trans('messages.Email').':') }}
                {{ Form::text('email',Input::old('email')) }}
            </div>
        </div>
        <div class="row">
            <div class="small-7 large-7 column">
                {{ Form::label('comment',Lang::choice('messages.Comments', 1).':') ) }}
                {{ Form::textarea('comment',Input::old('comment'),['rows'=>5]) }}
            </div>
        </div>
        <div class="row">
            <div class="small-7 large-7 column">
                {{ Form::label('image',trans('messages.Choose an image').':' ) }}
                {{ Form::file('image') }}
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
    @if(!Auth::check())
       {{ trans('messages.Captcha'); }}: {{ HTML::image(Captcha::img(),'alt captcha image') }}
       {{ Form::text('captcha') }}
    @endif
    {{ Form::submit(trans('messages.Submit'),['class'=>'button tiny radius']) }}
    {{ Form::close() }}
</div>
