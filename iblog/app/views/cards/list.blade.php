<h2 class="duty-listings">{{ trans('messages.Card listings'); }}</h2><hr>
@if ( Auth::check() && (Auth::user()->hasRole('BOSS') || Auth::user()->hasRole('admin') ) ) 
@if ( Auth::check() && Auth::user()->hasRole('admin') ) 
    <span class="right">{{ HTML::linkRoute('card.new',trans('messages.New').' '.Lang::choice('messages.Cards', 1),null,['class' => 'button tiny radius']) }}</span>
@endif
<table>
    <thead>
        <tr>
            <th width="10">{{ trans('messages.Color'); }}</th>
            <th width="600">{{ trans('messages.Content'); }}</th>                           
            <th width="80">{{ trans('messages.Name').'</br>'.trans('messages.Created at').'</br>'.trans('messages.Updated at'); }}</th>             
            @if ( Auth::check() && Auth::user()->hasRole('admin') ) 
                <th width="50">{{ 'Edit</br>Delete'; }}</th>                 
            @endif
            {{-- <th width="120">{{ Lang::choice('messages.Comments', 1); }}</th>     --}}
        </tr>
    </thead>
    <tbody>
    @foreach($cards as $card)
    <tr>
        <td bgcolor= 
            @if ($card->color == 2) "green" @endif
            @if ($card->color == 1) "yellow" @endif
            @if ($card->color == 0) "red" @endif
        ></td>
        <td>{{$card->content}}</td>        
        
        <td>{{$card->worker->name.'</br>'.$card->created_at.'</br>'.$card->updated_at }}</td>
        @if ( Auth::check() && Auth::user()->hasRole('admin') ) 
            <td>{{ HTML::linkRoute('card.edit','Edit',$card->id).'</br>'.HTML::linkRoute('card.delete','Delete',$card->id) }}</td>            
        @endif
      {{-- <td>{{$card->comment}}</td> --}}
    </tr>
    @endforeach
    </tbody>
</table>
{{$cards->links()}}
@else
  <h4>Карточки смотрят избранные</h4>
@endif