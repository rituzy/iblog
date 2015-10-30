<p><b>User_ID{{ trans('messages.if registred'); }}:</b> {{{$comment->user_id}}}</p>
<p><b>{{ trans('messages.Commenter').' '.trans('messages.if registred'); }}:</b> {{{$comment->commenter}}}</p>
<p><b>{{ trans('messages.Email').' '.trans('messages.if registred'); }}:</b> {{{$comment->email}}}</p>
<p><b>{{Lang::choice('messages.Comments', 1)}}:</b></p>
<p>{{{$comment->comment}}}</p>
<a class="close-reveal-modal">&#215;</a>
