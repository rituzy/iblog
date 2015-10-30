<article class="user">
    <header class="user-header">
        <h1 class="user-name">
            {{$user->username}}
        </h1>
        <div class="clearfix">
            {{--<span class="date">{{explode(' ',$user->created_at)[1]}}</span>            --}}
            {{ trans('messages.Created at').':'; }} {{$user->created_at}}
        </div>
    </header>
    <div class="user-email">
        <p>{{ trans('messages.Email').':'; }} {{ $user->email }}</p>
    </div>
    <footer class="user-footer">
        <span class="right">{{ HTML::linkRoute('user.edit',trans('messages.Edit'),['user' => $user->id],['class' => 'button tiny radius']) }}</span>
        <span class="right">&nbsp&nbsp</span>
        <span class="right">{{ HTML::linkRoute('user.delete',trans('messages.Delete'),['user' => $user->id],['class' => 'button tiny radius']) }}</span>
        <hr>

    </footer>
</article>
<section class="roles">
    @if(!$roles->isEmpty())
        <h2>{{ trans('messages.Roles of').' '; }}  {{$user->username}}</h2>
        <ul>
            @foreach($roles as $role)
                <li>
                    <article>                        
                        <div class="role-name">
                            <p>{{{$role->name}}}</p>
                        </div>
                        <footer>
                            <hr>
                        </footer>
                    </article>
                </li>
            @endforeach
        </ul>
    @else
        <h2>{{ trans('messages.No Roles on').' '; }} {{$user->username}}</h2>
    @endif    
</section>
