<h2 class="tag-listings">{{ trans('messages.Tag listings'); }}</h2><hr>
<table>
    <thead>
        <tr>            
            <th width="100">{{ trans('messages.Name'); }}</th>                        
            <th width="300">{{ trans('messages.Created at'); }}</th>
            <th width="300">{{ trans('messages.Created by'); }}</th>            
            <th width="300">{{ trans('messages.Edit'); }}</th>            
            <th width="120">{{ trans('messages.Delete'); }}</th>
            <th width="120">{{ trans('messages.Merge'); }}</th>            
        </tr>
    </thead>
    <tbody>
    {{Form::open(['route'=>['tag.merge']])}}
    @foreach($tags as $tag)        
            <tr>                
                <td>{{$tag->name}}</td>                
                <td>{{$tag->created_at}}</td>
                <td>
                    @foreach($users as $user)
                        @if($user->id == $tag->user_id)
                            {{$user->username}}
                        @endif
                    @endforeach
                    @if($tag->user_id == 0) {{ trans('messages.Anonymous'); }} @endif
                </td>
                <td>{{HTML::linkRoute('tag.edit',trans('messages.Edit'),$tag->id)}}</td>
                <td>{{HTML::linkRoute('tag.delete',trans('messages.Delete'),$tag->id)}}</td>
                <td>                    
                    {{ Form::checkbox( "$tag->id",1, false,['style'=>'margin-bottom:0'] ) }}
                </td>                
            </tr>        
    @endforeach
    </tbody>    
</table>
@if($errors->has())
    @foreach($errors->all() as $error)
    <div data-alert class="alert-box warning round">
        {{$error}}
        <a href="#" class="close">&times;</a>
    </div>
    @endforeach
@endif
<table>
    <tr>
    <td>I want to merge checked tags with</td>
    <td>{{ Form::select('mergeTag',array('default' => trans('messages.Select tag') ) + $tag_opt )}}</td>
    <td>{{ Form::submit(trans('messages.Merge'),['class'=>'button tiny radius']) }}</td>
    </tr>
</table>
{{Form::close()}}
{{$tags->links()}}