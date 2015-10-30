<h2 class="craft-listings">{{ trans('messages.Craft listings'); }}</h2><hr>
<span class="right">{{ HTML::linkRoute('craft.new',trans('messages.Add'),null,['class' => 'button tiny radius']) }}</span>
<table>
    <thead>
        <tr>
            <th width="300">{{ trans('messages.Craft title'); }}</th>
            <th width="300">{{ trans('messages.Craft title').'_RU'; }}</th>
            <th width="120">{{ trans('messages.Edit'); }}</th>
            <th width="120">{{ trans('messages.Delete'); }}</th>        
        </tr>
    </thead>
    <tbody>
    @foreach($crafts as $craft)
    <tr>
        <td>{{$craft->title}}</td>        
        <td>{{$craft->title_ru}}</td>   
        <td>{{HTML::linkRoute('craft.edit',trans('messages.Edit'),$craft->id)}}</td>
        <td>{{HTML::linkRoute('craft.delete',trans('messages.Delete'),$craft->id)}}</td>
    </tr>
    @endforeach
    </tbody>
</table>
{{$crafts->links()}}