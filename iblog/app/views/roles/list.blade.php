<h2 class="role-listings"> {{ trans('messages.Role listings'); }}</h2><hr>
<span class="right">{{ HTML::linkRoute('role.new',trans('messages.New').' '.Lang::choice('messages.Roles', 1),null,['class' => 'button tiny radius']) }}</span>
<table>
    <thead>
        <tr>
            <th width="300">{{ trans('messages.Name'); }}</th>
            <th width="120">{{ trans('messages.Edit'); }}</th>
            <th width="120">{{ trans('messages.Delete'); }}</th>            
        </tr>
    </thead>
    <tbody>
    @foreach($roles as $role)
    <tr>
        <td>{{$role->name}}</td>
        <td>{{HTML::linkRoute('role.edit',trans('messages.Edit'),$role->id)}}</td>
        <td>{{HTML::linkRoute('role.delete',trans('messages.Delete'),$role->id)}}</td>
    </tr>
    @endforeach
    </tbody>
</table>
{{$roles->links()}}
