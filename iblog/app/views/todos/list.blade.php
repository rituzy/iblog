<h2 class="album-listings">{{ trans('messages.Todo listings'); }}</h2><hr>
<span class="right">{{ HTML::linkRoute('todo.new',trans('messages.New').' '.Lang::choice('messages.Todos', 1),null,['class' => 'button tiny radius']) }}</span>

<div>

  {{ Form::open(['route'=>['todo.list.filtered']]) }}
  <table border=0>
    <tr>
        <td>  {{ Form::select('filter',['0' => trans('messages.All'), '1' => trans('messages.Actual') ,'2' => trans('messages.Not Actual')], $defaultActual,['style'=>'margin-bottom:0']) }} </td>
        <td>  {{ Form::checkbox('my',1,($my==1) ? true : false, ['style'=>'margin-bottom:0']) }} {{ " ".trans('messages.Created by me')."<br/>"}} </td>
        <td>
          @if( Auth::user()->hasRole('TODO') || Auth::user()->hasRole('admin') )
              {{ Form::checkbox('all',1,($all==1) ? true : false, ['style'=>'margin-bottom:0']) }} {{ " ".trans('messages.All todos')."<br/>"}}
          @endif
        </td>
        <td>  {{ Form::submit(trans('messages.Filter'),['class'=>'button tiny radius']) }} </td>
    </tr>
  </table>
  {{ Form::close() }}
</div>

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
        @if(  (
                ( Auth::user()->id == $todo->user_id
                  &&
                  ( $todo->author_id ==  Auth::user()->id  ||  $my == 0 )
                )
                ||
                ( $all == 1
                  &&
                  ( Auth::user()->hasRole('TODO') || Auth::user()->hasRole('admin') )
                )
              )

              &&
              (
                ( $todo->isActual() || $defaultActual <> 1)
                ||
                ( !$todo->isActual() || $defaultActual <> 2)
                ||
                ( $defaultActual == 0)
              )

            )
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
