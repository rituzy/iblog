<h2 class="new-role">{{ trans('messages.Add').' '.trans('messages.New').' '.Lang::choice('messages.Roles', 1); }}</h2>
<hr>
{{ Form::open(['route'=>['role.save']]) }}
<div class="row">
	<div class="small-5 large-5 column">
        {{ Form::label('name',trans('messages.Name').':') }}
        {{ Form::text('name',Input::old('name')) }}
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


