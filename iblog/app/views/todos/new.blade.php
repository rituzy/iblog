<h2 class="new-album">{{ trans('messages.New').' '.Lang::choice('messages.Todos', 1); }}</h2>
<hr>
{{ Form::open(['route'=>['todo.save']]) }}
<div class="row">
	<div class="small-5 large-5 column">
        {{ Form::label('content',trans('messages.Todo content').':') }}
        {{ Form::text('content',Input::old('content')) }}
    </div>
    <div class="small-5 large-5 column">
        {{ Form::label('deadline',trans('messages.Todo deadline').':') }}
        {{ Form::text('deadline',Input::old('deadline')) }}
    </div>
    <div class="small-5 large-5 column">
        {{ Form::label('priority',trans('messages.Todo priority').':') }}
        {{ Form::select('priority', [0, 1, 2], 1) }}        
    </div>
    <div class="small-5 large-5 column">
        {{ Form::label('status',trans('messages.Todo status').':') }}
        {{ Form::select('status', [trans('messages.New task')], trans('messages.New task')) }}        
    </div>
    @if(Auth::user()->hasRole('TODO'))
        <div class="small-5 large-5 column">
            <b>{{ trans('messages.Select user'); }}</b>:</br>
            {{ Form::select('uid', [Auth::user()->id => $users_opt[Auth::user()->id]]+$users_opt) }}
        </div>
    @else
        {{ Form::hidden('uid', Auth::user()->id); }}
    @endif
    {{ Form::hidden('author_uid', Auth::user()->id); }}
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


