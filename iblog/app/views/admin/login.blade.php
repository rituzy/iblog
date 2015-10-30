<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<meta name="_token" content="{!! csrf_token() !!}"/>
<h2>{{ trans('messages.Login page'); }} </h2><hr>
@if (!Auth::check())
 <?php

    $client_id = '5119114'; // ID приложения
    $client_secret = 'TpepuhmJcrSDlo5uVEzR'; // Защищённый ключ
    $redirect_uri = 'http://izutov.com/login'; // Адрес сайта

    $result = false;
    $url = 'http://oauth.vk.com/authorize';

    $params = array(
        'client_id'     => $client_id,
        'redirect_uri'  => $redirect_uri,
        'response_type' => 'code'
    );

    echo $link = '<p><a href="' . $url . '?' . 
    urldecode(http_build_query($params)) . 
    '">'.trans('messages.VKLog').'<img src=\'img/vk.png\' alt="VK" height="28" width="76"></img></a></p>';
    
    if ( isset($_GET['code']) ) {
        
        $params = array(
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'code' => $_GET['code'],
            'redirect_uri' => $redirect_uri
        );

        $token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);

        if (isset($token['access_token'])) {
            $params = array(
                'uids'         => $token['user_id'],
                'fields'       => 'uid,first_name,last_name,screen_name',
                'access_token' => $token['access_token'],            
            );

            $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);        
            if (isset($userInfo['response'][0]['uid'])) {
                $userInfo = $userInfo['response'][0];
                $result = true;
            }       
        }
    }

?>

   @if ($result)     
      <script type="text/javascript">
        $.ajaxSetup({
           headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });
      </script>

      <script>        

        $(document).ready(function () { 
        $.ajax({
                type: "post",
                url: './vkLogin',                                
                data: {                     
                    'uid':       {{ '\''.$userInfo['uid'].'\'' }},                         
                    'FirstName': {{ '\''.$userInfo['screen_name'].'\'' }} 
                      },
                success: function (result) {
                    window.location.replace('/');  
                }
               });
        });

        
      </script>         
    @else
        {{ Form::open(['action' => 'Admin\AdminController@postLogin']) }}
        <fieldset>
            <legend>{{ trans('messages.Login'); }}</legend>
            {{ Form::label( 'username',trans('messages.Username') ) }}
            {{ Form::text( 'username',Input::old('username'),
                         ['placeholder'=>trans('messages.Your nice name')] ) }}
            {{ Form::label( 'password',trans('messages.Password') ) }}
            {{ Form::password( 'password',['placeholder'=>trans('messages.Password here') ]) }}
            {{ Form::submit( trans('messages.Login'),['class'=>'button tiny radius']) }}
        </fieldset>
        {{ Form::close() }}
        @if($errors->has())
            @foreach ($errors->all() as $message)
                <span class="label alert round">{{$message}}</span><br><br>
            @endforeach
        @endif
        @if(Session::has('failure'))
            <span class="label alert round">{{Session::get('failure')}}</span>
        @endif
    @endif
@else
   <h3>already logged</h3>
@endif

 

