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

<h2 class="edit-post">
    {{ trans('messages.Edit').' '.Lang::choice('messages.Posts', 1); }}
    <span class="right">{{ HTML::linkRoute('post.list',trans('messages.Cancel'),null,['class' => 'button tiny radius']) }}</span>
</h2>
<hr>
{{ Form::open(['route'=>[ 'post.update',$post->id], 'files'=>true, 'id'=>'comment']) }}
<div class="row">
    <div class="small-5 large-5 column">
        {{ Form::label('title',trans('messages.Post title').':' ) }}
        {{ Form::text('title',Input::old('title',$post->title)) }}
    </div>
</div>
<div class="row">
    <div class="small-7 large-7 column">
        {{ Form::label('content',trans('messages.Content').':') }}
        {{ Form::textarea('content',Input::old('content',$post->content),['rows'=>5]) }}
    </div>
</div>
<div class="row">
    <div class="small-5 large-5 column">
        {{ Form::label('title_ru',trans('messages.Post title').'_RUS:' ) }}
        {{ Form::text('title_ru',Input::old('title_ru',$post->title_ru)) }}
    </div>
</div>
<div class="row">
    <div class="small-7 large-7 column">
        {{ Form::label('content_ru',trans('messages.Content').'_RUS:') }}
        {{ Form::textarea('content_ru',Input::old('content_ru',$post->content_ru),['rows'=>5]) }}
    </div>
</div>
<div class="row">
    <div class="small-7 large-7 column">
        {{ Form::label('image',trans('messages.Choose an image').':') }}
        {{ Form::file('image') }}
    </div>
</div>
<div>
    <div class="small-7 large-7 column">
        {{ Form::label('tag',trans('messages.Choose a tag').':') }}                           
        {{ Form::select('tag',array('default' => trans('messages.Select tag') ) + $tag_opt + array('new' => trans('messages.New tag')) )}}
        {{ Form::text('newTag',Input::old('newTag'),['id'=>'newTag']) }}
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
