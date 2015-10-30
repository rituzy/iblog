<h2 class="new-album">{{ trans('messages.New').' '.Lang::choice('messages.Albums', 1); }}</h2>
<hr>
{{ Form::open(['route'=>['album.save']]) }}
<div class="row">
	<div class="small-5 large-5 column">
        {{ Form::label('name',trans('messages.Name').':') }}
        {{ Form::text('name',Input::old('name')) }}
    </div>
    <div class="small-5 large-5 column">
        {{ Form::label('description',trans('messages.Description').':') }}
        {{ Form::text('description',Input::old('description')) }}
    </div>
        {{ Form::hidden('uid', Auth::user()->id); }}
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


