<!--file: app/views/auser/reset.blade.php-->

<h2 class="user-listings">Reset your password</h2><hr>
{{ Form::open() }}
		@if (Session::get("error"))
			{{ Session::get("error") }}<br />
		@endif
		{{ Form::label("email", "Email") }}
		{{ Form::text("email", Input::old("email")) }}
		{{ $errors->first("email") }}<br />
		{{ Form::label("password", "Password") }}
		{{ Form::password("password") }}
		{{ $errors->first("password") }}<br />
		{{ Form::label("password_confirmation", "Confirm") }}
		{{ Form::password("password_confirmation") }}
		{{ $errors->first("password_confirmation") }}<br />
		{{ Form::submit("reset") }}
{{ Form::close() }}
 

