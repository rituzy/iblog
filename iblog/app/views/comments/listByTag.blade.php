<h2 class="comment-listings">{{ trans('messages.Comment listings'); }}</h2><hr>
<table>
<thead>
    <tr>
        <th>{{ trans('messages.Commenter'); }}</th>
        <th>{{ trans('messages.Email'); }}</th>
        <th>{{ trans('messages.At post'); }}</th>
        <th>{{ trans('messages.Approved'); }}</th>
        <th>{{ trans('messages.Approved'); }}</th>
        <th>{{ trans('messages.Delete'); }}</th>
        <th>{{ trans('messages.View'); }}</th>
    </tr>
</thead>
<tbody>
    @foreach($comments as $comment)
    <tr>
        <td>
            @if($comment->user_id > 0)
                @foreach($users as $user)
                     @if($comment->user_id == $user->id)
                        {{{$user->username}}}
                     @endif
                @endforeach     
            @else
                {{{$comment->commenter}}}
            @endif    
        </td>
        <td>
            @if($comment->user_id > 0)
                @foreach($users as $user)
                     @if($comment->user_id == $user->id)
                        {{{$user->email}}}
                     @endif
                @endforeach     
            @else
                {{{$comment->email}}}
            @endif
        </td>
        @if ($comment->post)
            <td>{{{$comment->post->title}}}</td>
        @else
            <td>{{"no post!"}}</td>
        @endif
        <td>
            {{Form::open(['route'=>['comment.update',$comment->id]])}}                
                {{Form::select('status',[0=>trans('messages.No'),1=>trans('messages.Yes')],$comment->approved,['style'=>'margin-bottom:0','onchange'=>'submit()'])}}
            {{Form::close()}}
        </td>
        <td>{{$comment->approved}}</td>
        <td>{{HTML::linkRoute('comment.delete',trans('messages.Delete'),$comment->id)}}</td>
        <td>{{HTML::linkRoute('comment.show',trans('messages.View'),$comment->id,['data-reveal-id'=>'comment-show','data-reveal-ajax'=>'true'])}}</td>
    </tr>
    @endforeach
</tbody>
</table>
{{$comments->links()}}