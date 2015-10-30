<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    @section('title')
    <title>{{{$title}}}</title>
    @show
    {{ HTML::style('assets/css/foundation.css') }}
    {{ HTML::style('assets/css/custom.css') }}
    {{ HTML::script('./assets/js/vendor/custom.modernizr.js') }}
    
</head>
<body>
    <div class="row main">
    <div class="small-12 large-12 column" id="masthead">    
    <header>

    <nav class="top-bar" data-topbar>
        <ul class="title-area">
            <!-- Title Area -->
            <li class="name"></li>
            <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
            <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
            </ul>
            <section class="top-bar-section">
            <ul class="left">
            <li class="{{(strcmp(URL::full(), URL::to('/')) == 0) ? 'active' : ''}}"><a href="{{URL::to('/')}}">{{ trans('messages.Home'); }}</a></li>
            </ul>
            <ul class="left">
            <li>{{ link_to_route( 'language.select', 'English', ['en'] ) }}</li>
            </ul>
            <ul class="left">
            <li>{{ link_to_route( 'language.select', 'Russian', ['ru'] ) }}</li>
            </ul>
            
            <ul class="right">
                <li class="{{ '' }}">
                    {{HTML::link('crafts', trans('messages.My Crafts'))}}
                </li>
                <li class="{{ '' }}">
                    {{HTML::link('photos', trans('messages.My Photos'))}}
                </li>
            @if (Auth::check())              
                @if(Auth::user()->hasRole('admin'))
                    <li class="{{ (strpos(URL::current(), URL::to('admin/dash-board'))!== false) ? 'active' : '' }}">
                        {{HTML::link('admin/dash-board',trans('messages.AdminDashborad'))}}
                    </li>
                @endif 
                <li class="{{ (strpos(URL::current(), URL::to('logout'))!== false) ? 'active' : '' }}" >
                    {{HTML::linkRoute('user.show', trans('messages.Profile'),array(Auth::user()->id))}}
                </li>
                <li class="{{ (strpos(URL::current(), URL::to('logout'))!== false) ? 'active' : '' }}" >
                    {{HTML::link('logout', trans('messages.Logout'))}}
                </li>              
            @else
                <li class="{{ (strpos(URL::current(), URL::to('login'))!== false) ? 'active' : '' }}">
                    {{HTML::link('user/new', trans('messages.Register'))}}
                </li>
                <li class="{{ (strpos(URL::current(), URL::to('login'))!== false) ? 'active' : '' }}">
                    {{HTML::link('login', trans('messages.Login'))}}
                </li>                
            @endif
            </ul>
        </section>        
    </nav>    
    <div class="sub-header">        
        <hgroup>
            <h1>{{HTML::link('/',trans('messages.iBlog'))}}</h1>
            <h2>{{ trans('messages.IB'); }}</h2>            
        </hgroup>
    </div>
    </header>
    </div>
    <div class="row">
        {{$main}}
        </div>
        <div class="row">
            <div class="small-12 large-12 column">
                <footer class="site-footer"></footer>
            </div>
        </div>
    </div>
    {{ HTML::script('./assets/js/vendor/jquery.js') }}
    {{ HTML::script('./assets/js/foundation.min.js') }}
    <script>
        $(document).foundation();
    </script>  
</body>
</html>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-69407604-1', 'auto');
  ga('send', 'pageview');

</script>
