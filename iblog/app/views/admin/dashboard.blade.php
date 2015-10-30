<div class="small-3 large-3 column">
    <aside class="sidebar">
        <h3>{{ trans('messages.Menu'); }}</h3>
        <ul class="side-nav">
            <li>{{HTML::link('/',trans('messages.Home'))}}</li>
            <li class="divider"></li>
            <li class="{{ (strpos(URL::current(),route('post.new'))!== false) ? 'active' : '' }}">
                {{HTML::linkRoute( 'post.new',trans('messages.New').' '.Lang::choice('messages.Posts', 1) )}}
            </li >
            <li class="{{ (strpos(URL::current(),route('post.list'))!== false) ? 'active' : '' }}">
                {{HTML::linkRoute( 'post.list', Lang::choice('messages.Posts', 2) )}}
            </li>
            <li class="divider"></li>
            <li class="{{ (strpos(URL::current(),route('comment.list'))!== false) ? 'active' : '' }}">
                {{HTML::linkRoute('comment.list', Lang::choice('messages.Comments', 2) )}}
            </li>
            <li class="divider"></li>
            <li class="{{ (strpos(URL::current(),route('user.list'))!== false) ? 'active' : '' }}">
                {{HTML::linkRoute('user.list', Lang::choice('messages.Users', 2) )}}
            </li>
            <li class="{{ (strpos(URL::current(),route('role.list'))!== false) ? 'active' : '' }}">
                {{HTML::linkRoute('role.list', Lang::choice('messages.Roles', 2) )}}
            </li>
            <li class="{{ (strpos(URL::current(),route('tag.list'))!== false) ? 'active' : '' }}">
                {{HTML::linkRoute('tag.list', Lang::choice('messages.Tags', 2) )}}
            </li>
            <li class="{{ (strpos(URL::current(),route('craft.list'))!== false) ? 'active' : '' }}">
                {{HTML::linkRoute('craft.list', Lang::choice('messages.Crafts', 2) )}}
            </li>
            <li class="{{ (strpos(URL::current(),route('duty.list_upd'))!== false) ? 'active' : '' }}">
                {{HTML::linkRoute('duty.list_upd', Lang::choice('messages.Duties Upd', 2) )}}
            </li>
            <li class="{{ (strpos(URL::current(),route('duty.list_fill'))!== false) ? 'active' : '' }}">
                {{HTML::linkRoute('duty.list_fill', Lang::choice('messages.Duties Fill', 2) )}}
            </li>
            <li class="{{ (strpos(URL::current(),route('card.list'))!== false) ? 'active' : '' }}">
                {{HTML::linkRoute('card.list', Lang::choice('messages.Cards', 2) )}}
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
