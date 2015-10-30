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
<section class="comments">        
       <article>
          <header>
            <div class="clearfix">
              <span class="right date">{{ explode(' ',$comment->created_at)[0] }}</span>
              <span class="left commenter">{{ $comment->getCommenter() }}</span>                                 
            </div>
          </header>
          <div class="comment-content">
              {{ ( preg_match('/pncpictures/',$comment->image) == 1) ? HTML::image($comment->image, $comment->comment, ['widh'=>'400']) : '' }}
          </div>
          <div class="comment-content">
             <p>{{{$comment->comment}}}</p>
          </div> 
        </article>  
        {{ trans('messages.Comments on this comment').':' }}
        <ul>          
          @foreach( $comment->getChildComments() as $com)
            <li>
             <article>
                  <header>
                    <div class="clearfix">
                      <span class="right date">{{ explode(' ',$com->created_at)[0] }}</span>
                      <span class="left commenter">{{ $com->getCommenter() }}</span>                                 
                    </div>
                  </header>
                  <div class="comment-content">
                      {{ ( preg_match('/pncpictures/',$com->image) == 1) ? HTML::image($com->image, $com->comment, ['widh'=>'400']) : '' }}
                  </div>
                  <div class="comment-content">
                     <p>{{{$com->comment}}}</p>
                  </div>                  
                  <footer>
                     @if( $com->hasChildComments() )
                       <input class="toggle-box" id="{{ $com->id }}" type="checkbox" >
                       <label for="{{ $com->id }}">{{ trans('messages.Show comments on this comment').':' }}</label>
                       <div>                                                          
                          {{ trans('messages.Comments on this comment').':' }}
                          @include('comments.single',['comment'=>$com])                          
                       </div>
                     <hr>
                     @endif                     
                  </footer>
              </article>
            </li>
          @endforeach          
        </ul>
        @include('comments.comComment')                        
</section>

