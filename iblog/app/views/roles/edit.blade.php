<h2 class="edit-role">
	{{ trans('messages.Edit').' '.Lang::choice('messages.Roles', 1); }} <b> {{$role->name}}</b>
   <span class="right">{{ HTML::linkRoute('role.list',trans('messages.Cancel'),null,['class' => 'button tiny radius']) }}</span>
</h2>
<hr>
{{ Form::open(['route'=>['role.update',$role->id]]) }}
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
{{ Form::submit(trans('messages.Update'),['class'=>'button tiny radius']) }}
{{ Form::close() }}
 

