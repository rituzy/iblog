<h2 class="new-duty">
    {{ trans('messages.Add').' '.trans('messages.New').' '.Lang::choice('messages.Cards', 1); }}
    <span class="right">{{ HTML::link('admin/dash-board',trans('messages.Cancel'),['class' => 'button tiny radius']) }}</span>
</h2>
<hr>
{{ Form::open(['route'=>['card.save'] ]) }}
<div class="row">
    <div class="small-5 large-5 column">
        {{ Form::label('color',trans('messages.Color').':') }}
        {{ Form::select('color',['red','yellow','green'], Input::old('color')) }}
    </div>
</div>
<div class="row">
    <div class="small-7 large-7 column">
        {{ Form::label('content', trans('messages.Content').':') }}
        {{ Form::textarea('content',Input::old('content'),['rows'=>5]) }}
    </div>
</div>
<div class="row">
    <div class="small-7 large-7 column">
        {{ Form::label('comment', Lang::choice('messages.Comments', 1).':' }}
        {{ Form::textarea('comment',Input::old('comment'),['rows'=>5]) }}
    </div>
</div>
<div>
    <div class="small-7 large-7 column">
        {{ Form::label('worker_id',Lang::choice('messages.Workers', 1).':') }}                           
        {{ Form::select('worker_id', $worker_opt, Input::old('worker_id') )   }}         
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
