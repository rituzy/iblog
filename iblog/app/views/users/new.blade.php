<h2 class="new-user">{{ trans('messages.New User'); }}</h2>
<hr>
{{ Form::open(['route'=>['user.save']]) }}
<div class="row">
	<div class="small-5 large-5 column">
        {{ Form::label('username',trans('messages.Username').':') }}
        {{ Form::text('username',Input::old('username')) }}
    </div>
</div>
<div class="row">
	<div class="small-5 large-5 column">
        {{ Form::label('email',trans('messages.Email').':') }}
        {{ Form::text('email',Input::old('email')) }}
    </div>
</div>
<div class="row">
	<div class="small-5 large-5 column">
        {{ Form::label('password',trans('messages.Password').':') }}
        {{ Form::password('password') }}
    </div>
</div>
<div class="row">
	<div class="small-5 large-5 column">
        {{ Form::label('password_confirmation',trans('messages.Confirm').':') }}
        {{ Form::password('password_confirmation') }}
    </div>
</div>
<div class="row">
    <div class="small-5 large-5 column">
       {{ trans('messages.Captcha').':'; }} {{ HTML::image(Captcha::img(),'alt captcha image') }}
       {{ Form::text('captcha') }}
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
{{ Form::submit(trans('messages.Save'),['class'=>'button tiny radius']) }}
{{ Form::close() }}


