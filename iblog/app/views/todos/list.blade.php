<h2 class="album-listings">{{ trans('messages.Todo listings'); }}</h2><hr>
<span class="right">{{ HTML::linkRoute('todo.new',trans('messages.New').' '.Lang::choice('messages.Todos', 1),null,['class' => 'button tiny radius']) }}</span>
<table>
    <thead>
        <tr>
            <th width="600">{{ trans('messages.Todo content'); }}</th>
            <th width="30">{{ trans('messages.Todo deadline'); }}</th>
            <th width="20">{{ trans('messages.Todo priority'); }}
               </br>{{ '/'.trans('messages.Todo status'); }}
            </th>
            <th width="30">{{ Lang::choice('messages.Users', 1); }}</th>
            <th width="30">{{ Lang::choice('messages.Authors',1); }}</th>
            <th width="20">{{ trans('messages.Created at'); }}</th>
            <th width="20">{{ trans('messages.shortEdit').'</br>'.trans('messages.shortDelete'); }}</th>
        </tr>
    </thead>
    <tbody>
    @foreach($todos as $todo)
        @if(Auth::user()->id == $todo->user_id || Auth::user()->hasRole('TODO') || Auth::user()->hasRole('admin'))
            <tr>
                <td>{{$todo->content}}</td>
                <td>{{$todo->deadline}}</td>
                <td>{{$todo->priority}}</br>
                    {{'/'.$todo->getStatus()}}
                </td>
                <td>
                   @if( isset($users_opt[$todo->user_id]) )
                       {{ $users_opt[$todo->user_id] }}
                   @else
                       {{ trans('messages.Deleted') }}
                   @endif
                </td>
                <td>
                  @if( isset($users_opt[$todo->author_id]) )
                      {{ $users_opt[$todo->author_id] }}
                  @else
                      {{ trans('messages.Deleted') }}
                  @endif
                </td>
                <td>{{$todo->created_at}}</td>
                <td>{{HTML::linkRoute('todo.edit',trans('messages.shortEdit'),$todo->id)}}
                @if(Auth::user()->hasRole('admin')) </br>{{HTML::linkRoute('todo.delete',trans('messages.shortDelete'),$todo->id)}} @endif
                </td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
{{$todos->links()}}
