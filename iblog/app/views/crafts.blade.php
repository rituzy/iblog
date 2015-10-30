<h2 class="photo-listings">{{ trans('messages.Craft listings'); }}</h2><hr>
@if(!empty($notFound))
    <p>{{ trans('messages.SNFF'); }}</p>
@else        
<article>

    @foreach($crafts as $craft)
        <div>
            <b>{{ trans('messages.Craft title').': '; }} </b>
            {{ (Session::get('lang') === 'ru') ? $craft->title_ru : $craft->title }}            
        </div>
        <div class="craft-content">                                                            
            <p><b>{{ trans('messages.Description').': '; }} </b> 
                {{ (Session::get('lang') === 'ru') ? $craft->description_ru : $craft->description }}
                &nbsp;&nbsp;
            </br>
               <b>{{ trans('messages.Added by').': '; }} </b> {{ $craft->getCreatorName() }} &nbsp;&nbsp;
               <b>{{ trans('messages.At').': '; }} </b> {{ $craft->created_at}}
            </p>
            <p>
               <b>{{ trans('messages.Link').': '; }} </b> 
                <a href="{{ $craft->link }}{{ (Session::get('lang') === 'ru') ? '_ru.htm' : '_en.htm' }}">
                    {{ (Session::get('lang') === 'ru') ? $craft->title_ru : $craft->title }}
                </a>
            </p>
            <p>
                {{ ( preg_match('/pncpictures/',$craft->image) == 1) ? HTML::image($craft->image,
                        $craft->comment, ['widh'=>'400']) : '' }}
            </p>
        </div>            
    @endforeach
</article>
<footer class="craft-footer">
    <hr>
</footer>
{{$crafts->links()}}

@endif