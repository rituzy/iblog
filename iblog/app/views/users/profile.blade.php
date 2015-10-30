<!--file: app/views/auser/profile.blade.php-->

<h2 class="post-listings">{{ trans('messages.Your profile'); }}</h2><hr>
<h3>{{ trans('messages.Hello'); }} {{ Auth::user()->username }}</h3>
    <p>{{ trans('messages.WTYSPP'); }}</p>
 

