<section class="comments">     
  <ul>
    @foreach($comments2comments as $cc)
     @if ( $cc->comment_id == $comment->id )      
      <li>
       <article>
            <header>
              <div class="clearfix">
                <span class="right date">{{ explode(' ',$cc->created_at)[0] }}</span>
                <span class="left commenter">{{ $cc->getCommenter() }}</span>                                 
              </div>
            </header>
            <div class="comment-content">
                {{ ( preg_match('/pncpictures/',$cc->image) == 1) ? HTML::image($cc->image,
                          $cc->comment, ['widh'=>'400']) : '' }}
            </div>
            <div class="comment-content">
               <p>{{{$cc->comment}}}</p>
            </div> 
            <div>
               {{ link_to_route( 'comment.show.all', trans('messages.Comment to this comment'),$cc->id ) }}                          
            </div>
            <footer>
               @if( $cc->hasChildComments() )
                 <input class="toggle-box" id="{{ $cc->id }}" type="checkbox" >
                 <label for="{{ $cc->id }}">{{ trans('messages.Show comments on this comment').':' }}</label>
                 <div style="margin-left:10px">                     
                        {{ trans('messages.Comments on this comment').':' }}
                        @include( 'comments.single', array('comment'=>$cc) )
                 </div>
               @endif
               <hr>               
            </footer>
        </article>
      </li>
     @endif      
    @endforeach
  </ul>
</section>