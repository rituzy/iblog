<style type="text/css">
</style>
<h2 class="duty-listings">{{ trans('messages.Duty listings'); }}</h2><hr>
@if ( Auth::check() && Auth::user()->hasRole('admin') ) 
    <span class="right">{{ HTML::linkRoute('duty.new',trans('messages.Add').' '.Lang::choice('messages.Duties', 1),null,['class' => 'button tiny radius']) }}</span>
@endif
<table>
    <thead>
        <tr>
            <th width="50">{{ trans('messages.Current?'); }}</th> 
            <th width="50">{{ trans('messages.MonthPart'); }}</th>
            <th width="100">{{ trans('messages.Month'); }}</th>
            <th width="80">{{ trans('messages.Year'); }}</th>        
            <th width="150">{{ Lang::choice('messages.Workers', 1) }}</th>        
            @if ( Auth::check() && Auth::user()->hasRole('admin') ) 
                <th width="120">{{ trans('messages.Edit'); }}</th> 
                <th width="120">{{ trans('messages.Delete'); }}</th> 
            @endif
        </tr>
    </thead>
    <tbody>
    @foreach($duties as $duty)
    <tr>
        <td>
        @if (    $nowDuty->year      == $duty->year
              && $nowDuty->month     == $duty->month
              && $nowDuty->monthPart == $duty->monthPart              
            )
            <b>{{ trans('messages.Yes'); }}</b>        
        @endif    
        </td>
        <td>{{$duty->monthPart}}</td>        
        <td>{{$duty->month}}</td>        
        <td>{{$duty->year}}</td>        
        <td>{{$duty->worker->name}}</td>
        @if ( Auth::check() && Auth::user()->hasRole('admin') ) 
            <td>{{HTML::linkRoute('duty.edit','Edit',$duty->id)}}</td>
            <td>{{HTML::linkRoute('duty.delete','Delete',$duty->id)}}</td>
        @endif        
    </tr>
    @endforeach
    </tbody>
</table>
{{$duties->links()}}