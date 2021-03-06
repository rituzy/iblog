<h2 class="new-duty">
    {{ trans('messages.Add').' '.Lang::choice('messages.Duties', 1); }}
    <span class="right">{{ HTML::link('admin/dash-board',trans('messages.Cancel'),['class' => 'button tiny radius']) }}</span>
</h2>
<hr>
{{ Form::open(['route'=>['duty.save'] ]) }}
<div class="row">
    <div class="small-5 large-5 column">
        {{ Form::label('monthPart',trans('messages.MonthPart').':') }}
        {{ Form::select('monthPart',[0,1,2], Input::old('monthPart')) }}
    </div>
</div>
<div class="row">
    <div class="small-7 large-7 column">
        {{ Form::label('month', trans('messages.Month').':') }}
        {{ Form::selectMonth('month',Input::old('month')) }}
    </div>
</div>
<div class="row">
    <div class="small-7 large-7 column">
        {{ Form::label('year', trans('messages.Year').':')    }}
        {{ Form::selectYear( 'year',2015, 2020, Input::old('year') ) }}
    </div>
</div>
<div class="row">
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
