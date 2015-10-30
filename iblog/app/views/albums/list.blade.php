<h2 class="album-listings">{{ trans('messages.Album listings'); }}</h2><hr>
<span class="right">{{ HTML::linkRoute('album.new',trans('messages.New').' '.Lang::choice('messages.Albums', 1),null,['class' => 'button tiny radius']) }}</span>
<table>
    <thead>
        <tr>
            <th width="300">{{ trans('messages.Album name'); }}</th>
            <th width="300">{{ trans('messages.Album description'); }}</th>
            <th width="120">{{ Lang::choice('messages.Roles', 2); }}</th>
            <th width="300">{{ trans('messages.Created at'); }}</th>
            <th width="300">{{ trans('messages.Created by'); }}</th>
            <th width="120">{{ trans('messages.Edit'); }}</th>            
            @if(Auth::user()->hasRole('admin')) <th width="120">{{ trans('messages.Delete'); }}</th> @endif
        </tr>
    </thead>
    <tbody>
    @foreach($albums as $album)
        @if(Auth::user()->id == $album->user_id || Auth::user()->hasRole('admin'))
            <tr>
                <td>{{$album->name}}</td>
                <td>{{$album->description}}</td>
                <td>
                    @if(Auth::user()->hasRole('admin'))
                      <p>
                       <small>
                        @foreach($roles as $role) 
                          {{Form::open(['route'=>['albumRole.update',$album->id]])}}                
                            {{ Form::hidden("$role->name", 0); }}
                            {{ Form::checkbox("$role->name",1,($album->hasRole($role->name)) ? true : false,
                                                        ['style'=>'margin-bottom:0','onchange'=>'submit()'])}}
                            {{ " ".$role->name }}
                          {{Form::close()}}
                        @endforeach
                       </small> 
                      </p>  
                    @else
                      <p>
                       <small>
                        @foreach($roles as $role)                           
                            @if($album->hasRole($role->name)) {{ $role->name }} @endif
                        @endforeach
                       </small> 
                      </p>  
                    @endif
                </td>
                <td>{{$album->created_at}}</td>
                <td>
                    @foreach($users as $user)
                        @if($user->id == $album->user_id)
                            {{$user->username}}
                        @endif
                    @endforeach
                </td>
                <td>{{HTML::linkRoute('album.edit',trans('messages.Edit'),$album->id)}}</td>
                @if(Auth::user()->hasRole('admin')) <td>{{HTML::linkRoute('album.delete',trans('messages.Delete'),$album->id)}}</td> @endif       
            </tr>
        @endif    
    @endforeach
    </tbody>
</table>
{{$albums->links()}}