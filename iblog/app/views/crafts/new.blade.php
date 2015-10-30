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

<h2 class="new-craft">
    {{ Lang::choice('messages.Crafts', 2).': '.trans('messages.Add'); }}
    <span class="right">{{ HTML::link('admin/dash-board',trans('messages.Cancel'),['class' => 'button tiny radius']) }}</span>
</h2>
<hr>
{{ Form::open(['route'=>['craft.save'] ,'files'=>true, 'id'=>'comment']) }}
<div class="row">
    <div class="small-5 large-5 column">
        {{ Form::label('title',trans('messages.Craft title').':') }}
        {{ Form::text('title',Input::old('title')) }}
    </div>
</div>
<div class="row">
    <div class="small-7 large-7 column">
        {{ Form::label('description',trans('messages.Description').':') }}
        {{ Form::textarea('description',Input::old('description'),['rows'=>5]) }}
    </div>
</div>
<div class="row">
    <div class="small-5 large-5 column">
        {{ Form::label('title_ru', trans('messages.Craft title').'_RUS:') }}
        {{ Form::text('title_ru',Input::old('title_ru') ) }}
    </div>
</div>
<div class="row">
    <div class="small-7 large-7 column">
        {{ Form::label('description_ru',trans('messages.Description').'_RUS:') }}
        {{ Form::textarea('description_ru',Input::old('description_ru'),['rows'=>5]) }}
    </div>
</div>
<div class="row">
    <div class="small-7 large-7 column">
        {{ Form::label('link',trans('messages.Link').':') }}
        {{ Form::text('link',Input::old('link'),['rows'=>5]) }}
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
        {{ Form::label('tag',trans('messages.Choose a tag')) }}                           
        {{ Form::select('tag',array('default' => trans('messages.Select tag') ) + $tag_opt + array('new' => trans('messages.New tag') ) )}}
        {{ Form::text('newTag',Input::old('newTag'),['id'=>'newTag']) }}
    </div>
</div>
{{ Form::hidden('uid', Auth::user()->id); }}
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
