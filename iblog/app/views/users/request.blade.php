<!--file: app/views/auser/profile.blade.php-->

<h2 class="post-listings">Request your password!</h2><hr>
<{{ Form::open() }}
    {{ Form::label("email", "Email") }}
    {{ Form::text("email", Input::old("email")) }}
    {{ Form::submit("reset") }}
{{ Form::close() }}
