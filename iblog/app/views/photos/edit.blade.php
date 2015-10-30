<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("jquery", "1.4.4");
</script>
<script type="text/javascript">
    $(function(){
        //initially hide the textbox
        $("#newTag").hide();
        $('#tag').change(function() {
          if($(this).find('option:selected').val() == "new"){
            $("#newTag").show();
          }else{
            $("#newTag").hide();
          }
        });
        $("#newTag").keyup(function(ev){
            var othersOption = $('#tag').find('option:selected');
            if(othersOption.val() == "new")
            {
                ev.preventDefault();
                //change the selected drop down text
                $(othersOption).html($("#newTag").val()); 
            } 
        });
        $('#comment').submit(function() {
            var othersOption = $('#tag').find('option:selected');
            if(othersOption.val() == "new")
            {
                // replace select value with text field value
                othersOption.val($("#newTag").val());
            }
        });
    });
</script>

<h2 class="edit-photo">
	{{ trans('messages.Edit').' '.Lang::choice('messages.Photos', 1); }}<b> {{$photo->description}}</b>
   <span class="right">{{ HTML::linkRoute('photo.list',trans('messages.Cancel'),null,['class' => 'button tiny radius']) }}</span>
</h2>
<hr>
@if(Auth::user()->id == $photo->user_id || Auth::user()->hasRole('admin'))
    {{ Form::open(['route'=>['photo.update',$photo->id],'files'=>true, 'id'=>'comment']) }}
    <div class="row">
        <div class="small-5 large-5 column">    
            {{ Form::label('photo',trans('messages.Choose a photo').':') }}
            {{ Form::file('photo')}}
        </div>
        <div class="small-5 large-5 column">
            {{ Form::label('description',trans('messages.Description').':') }}
            {{ Form::text('description',Input::old('description')) }}
        </div>
       <div class="small-5 large-5 column">
            {{ Form::label('album_id',Lang::choice('messages.Albums', 1).':') }}
            {{ Form::select('album_id', $albums_opt,Input::old('albums')) }}
        </div>
        <div class="small-5 large-5 column">
            {{ HTML::image($photo->getPhotoImage(),$photo->description) }}
        </div>
        <div class="small-5 large-5 column">
            {{ Form::label('tag',trans('messages.Choose a tag').':' ) }}                           
            {{ Form::select('tag',array('default' => trans('messages.Select tag') ) + $tag_opt + array('new' => trans('messages.New tag') ) )}}
            {{ Form::text('newTag',Input::old('newTag'),['id'=>'newTag']) }}
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
    {{ trans('messages.YDNHRTEP'); }}
@endif
 

