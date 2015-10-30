<h2 class="duty-listings">{{ trans('messages.Card listings'); }}</h2><hr>
@if ( Auth::check() && Auth::user()->hasRole('admin') ) 
    <span class="right">{{ HTML::linkRoute('card.new',trans('messages.New').' '.Lang::choice('messages.Cards', 1),null,['class' => 'button tiny radius']) }}</span>
@endif
<table>
    <thead>
        <tr>
            <th width="300">{{ trans('messages.Color'); }}</th>
            <th width="120">{{ trans('messages.Content'); }}</th>
            <th width="120">{{ Lang::choice('messages.Comments', 1); }}</th>        
            <th width="120">{{ Lang::choice('messages.Comments', 1); }}</th>        
            <th width="120">{{ trans('messages.Created at'); }}</th> 
            <th width="120">{{ trans('messages.Updated at'); }}</th> 
            @if ( Auth::check() && Auth::user()->hasRole('admin') ) 
                <th width="120">{{ trans('messages.Edit'); }}</th> 
                <th width="120">{{ trans('messages.Delete'); }}</th> 
            @endif
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
        <td>{{$card->comment}}</td>        
        <td>{{$card->worker->name}}</td>
        <td>{{$card->created_at}}</td>
        <td>{{$card->updated_at}}</td>
        @if ( Auth::check() && Auth::user()->hasRole('admin') ) 
            <td>{{HTML::linkRoute('card.edit','Edit',$card->id)}}</td>
            <td>{{HTML::linkRoute('card.delete','Delete',$card->id)}}</td>
        @endif
    </tr>
    @endforeach
    </tbody>
</table>
{{$cards->links()}}