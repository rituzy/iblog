<h2 class="edit-tag">
	{{ trans('messages.Edit').' '.Lang::choice('messages.Tags', 1); }}<b> {{$tag->name}}</b>
   <span class="right">{{ HTML::linkRoute('tag.list','Cancel',null,['class' => 'button tiny radius']) }}</span>
</h2>
<hr>
{{ Form::open(['route'=>['tag.update',$tag->id]]) }}
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