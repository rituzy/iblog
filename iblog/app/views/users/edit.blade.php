<h2 class="edit-user">
	{{ trans('messages.Edit'); }} <b> {{$user->username}}</b>
   <span class="right">{{ HTML::linkRoute('user.list',trans('messages.Cancel'),null,['class' => 'button tiny radius']) }}</span>
</h2>
<hr>
{{ Form::open(['route'=>['user.update',$user->id]]) }}
<div class="row">
	<div class="small-5 large-5 column">
        {{ Form::label('username', trans('messages.Username').':') }}
        {{ Form::text('username',$user->username) }}
    </div>
</div>
<div class="row">
	<div class="small-5 large-5 column">
        {{ Form::label('email', trans('messages.Email').':') }}
        {{ Form::text('email',$user->email) }}
    </div>
</div>
<div class="row">
	<div class="small-5 large-5 column">
        {{ Form::label('password', trans('messages.Password').':') }}
        {{ Form::password('password',Input::old('Password')) }}
    </div>
</div>
<div class="row">
	<div class="small-5 large-5 column">
        {{ Form::label('password_confirmation', trans('messages.Confirm').':') }}
        {{ Form::password('password_confirmation') }}
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
{{ Form::submit(trans('messages.Update'),['class'=>'button tiny radius']) }}
{{ Form::close() }}
 

