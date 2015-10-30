<div id="comment-content" class="comment-form">
    <a class="close-btn" href="javascript:void(0)" onclick ="document.getElementById('envelope').
               style.display='none';document.getElementById('fade').style.display='none'"></a>        
    @if(!Auth::check())
       @include('comments.comCommentformnr')
    @else
       @include('comments.comCommentformr')
    @endif
</div>