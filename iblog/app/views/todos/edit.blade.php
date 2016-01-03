<h2 class="edit-album">
	{{ trans('messages.Edit').' '.Lang::choice('messages.Todos', 1); }} <b> {{ substr($todo->content,0,12).'...' }}</b>
   <span class="right">{{ HTML::linkRoute('todo.list',trans('messages.Cancel'),null,['class' => 'button tiny radius']) }}</span>
</h2>
<hr>

{{ Form::open(['route'=>['todo.update',$todo->id]]) }}
<div class="row">
    <div class="small-5 large-5 column">
        {{ Form::label('content',trans('messages.Todo content').':') }}
        {{ Form::text('content',$todo->content) }}
    </div>
    <div class="small-5 large-5 column">
        {{ Form::label('deadline',trans('messages.Todo deadline').':') }}
        {{ Form::text('deadline',$todo->deadline) }}
    </div>
    <div class="small-5 large-5 column">
        {{ Form::label('priority',trans('messages.Todo priority').':') }}
        {{ Form::select('priority', [0, 1, 2], $todo->priority) }}
    </div>
    <div class="small-5 large-5 column">
        {{ Form::label('status',trans('messages.Todo status').':') }}
        {{ Form::select('status', [trans('messages.New task'),trans('messages.Done'),trans('messages.Fucked up'),trans('messages.Rejected')], $todo->status) }}
    </div>
    @if(Auth::user()->hasRole('TODO'))
        <div class="small-5 large-5 column">
            <b>{{ trans('messages.Select user'); }}</b>:</br>
            {{ Form::select('uid', [$todo->user->id => $users_opt[$todo->user->id]]+$users_opt) }}
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
{{ Form::submit(trans('messages.Update'),['class'=>'button tiny radius']) }}
{{ Form::close() }}
