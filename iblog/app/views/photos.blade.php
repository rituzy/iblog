<h2 class="photo-listings">{{ trans('messages.PoL'); }}</h2><hr>
@if(!empty($notFound))
    <p>{{ trans('messages.SNF'); }}</p>
@else
    <div>
        <table>
          <tr>
          <td valign = 'top'>
            <b>{{ trans('messages.Filter by album'); }}</b>:</br>   
            {{Form::open(['route'=>['photos.show.album']])}}
                @foreach($albums as $album)                 
                    {{ Form::checkbox(preg_replace('/\s+/','_',"$album->name"),1,
                        (in_array($album->name,$checked_albums)) ? true : false,
                        ['style'=>'margin-bottom:0'])
                    }}
                    {{ " "."$album->name"."<br/>"}}
                @endforeach
                {{ Form::submit(trans('messages.Filter by album'),['class'=>'button tiny radius']) }}            
            {{Form::close()}}
            
          </td>
          <td valign = 'top'>
            <b>{{ trans('messages.Filter by user'); }}</b>:</br>
            {{ Form::open(['route'=>['photos.show.user']]) }}
                {{ Form::select('user_id',array('default' => trans('messages.Select user')) 
                                        + array('all' => trans('messages.All'))                          
                                        + $users_opt,(isset($uid)) ? $uid : 'default',['style'=>'margin-bottom:0','onchange'=>'submit()']) }}        
            {{ Form::close() }}  
          </td>
          <td valign = 'top'>
            <b>{{ trans('messages.Younger than'); }}</b>:</br>
            {{Form::open(['route'=>['photos.show.date']])}}         
                 {{ Form::selectYear('year', 2015, 2020,(isset($year)) ? $year : 2015) }}
                 {{ Form::selectMonth('month', (isset($month)) ? $month : 1) }}
                 {{ Form::selectDay('day',1,31, (isset($day)) ? $day : 1) }}
                 {{ Form::submit(trans('messages.Filter by date'),['class'=>'button tiny radius']) }}
            {{Form::close()}}
          </td>
          </tr>
        </table>
    </div>

    @foreach($albums as $album)
        @if ( !is_null(Auth::user()) && !$album->isAllowedUser(Auth::user()->id) )        
            {{ trans('messages.a2al',['album'=>$album->name]); }}. {{ trans('messages.conAdm'); }}</br>
        @endif
    @endforeach

    @foreach($albums as $album)
    @if ( !is_null(Auth::user()) && $album->isAllowedUser(Auth::user()->id) )        
        @if( isset($album_ids) )            
            @if(in_array($album->id,$album_ids))
                <article class="post">
                    <header class="post-header">
                        <h1 class="post-title">
                            {{ Lang::choice('messages.Albums', 1).' : '.$album->name }}  
                        </h1>
                        <div class="clearfix">                            
                            <span class="right label">{{ $album->description }}</span>
                        </div>
                    </header>
                    @if(isset($photos))  
                        @foreach($photos as $photo)
                            @if($photo->album_id == $album->id) 
                                <div class="post-content">                        
                                    {{ HTML::image($photo->getPhotoImage(), $photo->description, ['widh'=>'600']) }}
                                    <p>{{ trans('messages.Description'); }}:  {{  ($photo->description == '') ? 'none' : $photo->description }} &nbsp;&nbsp;
                                       {{ trans('messages.Added by'); }}: {{ $photo->getCreatorName() }} &nbsp;&nbsp;
                                       {{ trans('messages.At'); }}: {{ $photo->created_at}}
                                    </p>
                                </div>
                            @endif
                        @endforeach
                    @else
                        @foreach($album->photos as $photo)
                            <div class="post-content">                        
                                {{ HTML::image($photo->getPhotoImage(), $photo->description, ['widh'=>'600']) }}
                                <p>{{ trans('messages.Description'); }}:  {{ ($photo->description == '') ? 'none' : $photo->description }} &nbsp;&nbsp;
                                   {{ trans('messages.Added by'); }}: {{ $photo->getCreatorName() }} &nbsp;&nbsp;
                                   {{ trans('messages.At'); }}: {{ $photo->created_at }}
                                </p>
                            </div>
                        @endforeach
                    @endif
                </article>
                <footer class="post-footer">
                        <hr>
                </footer>
            @endif
        @else 
            {{ trans('messages.oops'); }}
        @endif
    @else
        {{--U don't have an access to album "{{ $album->name }}" or u've not logged in.</br>--}}
    @endif
    @endforeach
    {{$albums->links()}}
 
@endif