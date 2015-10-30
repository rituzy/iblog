<h2 class="edit-album">
	{{ trans('messages.Edit').' '.Lang::choice('messages.Albums', 1); }} <b> {{$album->name}}</b>
   <span class="right">{{ HTML::linkRoute('album.list',trans('messages.Cancel'),null,['class' => 'button tiny radius']) }}</span>
</h2>
<hr>
@if(Auth::user()->id == $album->user_id || Auth::user()->hasRole('admin'))
    {{ Form::open(['route'=>['album.update',$album->id]]) }}
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
    {{ Form::submit(trans('messages.Update'),['class'=>'button tiny radius']) }}
    {{ Form::close() }}
@else
    {{ trans('messages.YRTTA'); }}
@endif
