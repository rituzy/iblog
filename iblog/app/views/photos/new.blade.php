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

<h2 class="new-photo">{{ trans('messages.Add').' '.Lang::choice('messages.Photos', 1); }}</h2>
<hr>
{{ Form::open(['route'=>['photo.save'], 'files'=>true, 'id'=>'comment']) }}
<div class="row">
	<div class="small-5 large-5 column">
        {{ Form::label('photo',trans('messages.Choose a photo').':' ) }}
        {{ Form::file('photo'),Input::old('photo') }}
    </div>
    <div class="small-5 large-5 column">
        {{ Form::label('description',trans('messages.Description').':') }}
        {{ Form::text('description',Input::old('description')) }}
    </div>
    <div class="small-5 large-5 column">
        {{ Form::label('album_id',Lang::choice('messages.Albums', 1).':') }}
        {{ Form::select('album_id', $albums_opt,Input::old('album_id')) }}
    </div>        
    <div class="small-5 large-5 column">
        {{ Form::label('tag',trans('messages.Choose a tag').':') }}                           
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
{{ Form::submit(trans('messages.Save'),['class'=>'button tiny radius']) }}
{{ Form::close() }}


