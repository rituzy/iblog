<div class="small-3 large-3 column">
    <aside class="sidebar">
        <h3>{{ trans('messages.Menu'); }}</h3>
        <ul class="side-nav">
            <li>{{ HTML::link('/',trans('messages.Home') ) }}</li>
            <li class="divider"></li>
            <li class="{{ (strpos(URL::current(),route('user.new'))!== false) ? 'active' : '' }}">
                {{ HTML::linkRoute('user.new',trans('messages.New User') ) }}
            </li>           
            @if(Auth::user())
                <li class="{{ (strpos(URL::current(),route('user.edit','user'))!== false) ? 'active' : '' }}">
                    {{HTML::linkRoute('user.edit', trans('messages.Edit User'), Auth::user()->id)}}
                </li>
                <li class="divider"></li>
                <li class="{{ (strpos(URL::current(),route('user.delete','user'))!== false) ? 'active' : '' }}">
                    {{HTML::linkRoute('user.delete', trans('messages.User Delete'), Auth::user()->id)}}
                </li>
                <li class="divider"></li>
                <li class="{{ (strpos(URL::current(),route('album.list'))!== false) ? 'active' : '' }}">
                    {{HTML::linkRoute('album.list', trans('messages.LCPA') )}}
                </li>
                <li class="divider"></li>
                <li class="{{ (strpos(URL::current(),route('photo.list'))!== false) ? 'active' : '' }}">
                    {{HTML::linkRoute('photo.list',trans('messages.LCP') )}}
                </li>
                <li class="{{ (strpos(URL::current(),route('todo.list'))!== false) ? 'active' : '' }}">
                    {{HTML::linkRoute('todo.list',trans('messages.Todo listings') )}}
                </li>
            @endif
            <li class="divider"></li>            
                
            </li> 
        </ul>
    </aside>
</div>
<div class="small-9 large-9 column">
    <div class="content">
        @if(Session::has('success'))
            <div data-alert class="alert-box round">
                {{Session::get('success')}}
                <a href="#" class="close">&times;</a>
            </div>
        @endif
        {{$content}}
    </div>
    <div id="comment-show" class="reveal-modal small" data-reveal>
        {{-- quick comment using ajax --}}
    </div>
</div>