<article class="craft">
    <header class="craft-header">
        <h1 class="craft-title">
            {{$craft->title}}
        </h1>
        <div class="clearfix">
            <span class="left date">{{explode(' ',$craft->created_at)[0]}}</span>            
        </div>
    </header>
    <div class="craft-content">
        <p>{{ $craft->description }}</p>
    </div>
    <div class="craft-content">
        <p>{{ $craft->link }}</p>
    </div>
    
    <footer class="craft-footer">
        <hr>
        <div class="craft-content">
            {{ HTML::image($craft->image, $craft->title, ['widh'=>'400']) }}
        </div>
    </footer>
</article>
