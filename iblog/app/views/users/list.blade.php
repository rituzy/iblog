<h2 class="user-listings">{{ trans('messages.User listings'); }}</h2><hr>
<table>
    <thead>
        <tr>
            <th width="300">{{ trans('messages.Userame'); }}</th>
            <th width="120">{{ trans('messages.Edit'); }}</th>
            <th width="120">{{ trans('messages.Delete'); }}</th>
            <th width="120">{{ Lang::choice('messages.Roles', 2); }}</th>
            <th width="120">{{ trans('messages.View'); }}</th>
        </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
    <tr>
        <td>{{$user->username}}</td>
        <td>{{HTML::linkRoute('user.edit.adm',trans('messages.Edit'),$user->id)}}</td>
        <td>{{HTML::linkRoute('user.delete.adm',trans('messages.Delete'),$user->id)}}</td>

        <td>
          <p>
           <small>
            @foreach($roles as $role) 
              {{Form::open(['route'=>['userRole.update',$user->id]])}}                
                {{ Form::hidden("$role->name", 0); }}
                {{ Form::checkbox("$role->name",1,($user->hasRole($role->name)) ? true : false,
                                            ['style'=>'margin-bottom:0','onchange'=>'submit()'])}}
                {{ " ".$role->name }}
              {{Form::close()}}
            @endforeach
           </small>
          </p>
        </td>
        
        <td>{{HTML::linkRoute('user.show.adm',trans('messages.View'),$user->id,['target'=>'_blank'])}}</td>
    </tr>
    @endforeach
    </tbody>
</table>
{{$users->links()}}