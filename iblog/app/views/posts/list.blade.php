<h2 class="post-listings">{{ trans('messages.Post listings') }}</h2><hr>
<table>
    <thead>
        <tr>
            <th width="300">{{ trans('messages.Post title') }}</th>
            <th width="300">{{ trans('messages.Post title').'_RUS' }}</th>
            <th width="120">{{ trans('messages.Edit') }}</th>
            <th width="120">{{ trans('messages.Delete') }}</th>
            <th width="120">{{ trans('messages.View') }}</th>
        </tr>
    </thead>
    <tbody>
    @foreach($posts as $post)
    <tr>
        <td>{{$post->title}}</td>
        <td>{{$post->title_ru}}</td>
        <td>{{HTML::linkRoute('post.edit',trans('messages.Edit'),$post->id)}}</td>
        <td>{{HTML::linkRoute('post.delete',trans('messages.Delete'),$post->id)}}</td>
        <td>{{HTML::linkRoute('post.show',trans('messages.View'),$post->id,['target'=>'_blank'])}}</td>
    </tr>
    @endforeach
    </tbody>
</table>
{{$posts->links()}}