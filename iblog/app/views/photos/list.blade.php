<?php
require app_path() . "/macros.php";
?>

<h2 class="photo-listings">{{ trans('messages.Photo listings'); }}</h2><hr>
<div>
    <table>
      <tr>        
      <td valign = 'top'>
        <b>{{ trans('messages.Filter by album'); }}</b>:</br>   
        {{Form::open(['route'=>['photo.list.album']])}}
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
        {{ Form::open(['route'=>['photo.list.user']]) }}
            {{ Form::select('user_id',array('default' => 'Select user') 
                                    + array('all' => 'All')                          
                                    + $users_opt,(isset($uid)) ? $uid : 'default',['style'=>'margin-bottom:0','onchange'=>'submit()']) }}        
        {{ Form::close() }}  
      </td>
      <td valign = 'top'>
        <b>{{ trans('messages.Younger than'); }}</b>:</br>
        {{Form::open(['route'=>['photo.list.date']])}}         
             {{ Form::selectYear('year', 2015, 2020,(isset($year)) ? $year : 2015) }}
             {{ Form::selectMonth('month', (isset($month)) ? $month : 1) }}
             {{ Form::selectDay('day',1,31, (isset($day)) ? $day : 1) }}
             {{ Form::submit(trans('messages.Filter by date'),['class'=>'button tiny radius']) }}
        {{Form::close()}}
      </td>
      </tr>
    </table>
</div>

<span class="right">{{ HTML::linkRoute('photo.new',trans('messages.Add').' '.Lang::choice('messages.Photos', 1),null,['class' => 'button tiny radius']) }}</span>
<table>
    <thead>
        <tr>
            <th width="300">{{ Lang::choice('messages.Photos', 1); }}</th>
            <th width="300">{{ trans('messages.Description'); }}</th>
            <th width="300">{{ Lang::choice('messages.Albums', 1); }}</th>
            <th width="300">{{ trans('messages.Created at'); }}</th>
            <th width="300">{{ trans('messages.Created by'); }}</th>
            <th width="120">{{ trans('messages.Edit'); }}</th>            
            @if(Auth::user()->hasRole('admin')) <th width="120">{{ trans('messages.Delete'); }}</th> @endif
        </tr>
    </thead>
    <tbody>
    @foreach($photos as $photo)
      @if(Auth::user()->id == $photo->user_id || Auth::user()->hasRole('admin'))
      <tr>
          <td>{{ HTML::image($photo->getPhotoImage(),$photo->description,['width'=>'40']) }}</td>
          <td>{{ $photo->description }}</td>    
          <td>{{ $photo->getAlbumName() }} </td>        
          <td>{{ $photo->created_at }}</td>
          <td>{{ $photo->getCreatorName() }}</td>        
          <td>{{ HTML::linkRoute('photo.edit','Edit',$photo->id) }}</td>
          @if(Auth::user()->hasRole('admin')) <td>{{ HTML::linkRoute('photo.delete','Delete',$photo->id) }}</td> @endif
      </tr>
      @endif
    @endforeach
    </tbody>
</table>
{{$photos->links()}}