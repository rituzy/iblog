<?php
 
class SingleUserController extends UserController{	

    public function showUser(User $user)
	{
	    $roles = $user->roles()->get(); 
	    $this->layout->title = $user->username;
	    $this->layout->main = View::make('users.dashboard',compact('user'))->nest('content','users.single',compact('user','roles'));
	}
	 
	public function newUser()
	{
	    $this->layout->title = trans('messages.New').' '.Lang::choice('messages.Users', 1);
	    $this->layout->main = View::make('users.dashboard')->nest('content','users.new');
	 }
	 
	public function editUser(User $user)
	{
	    $this->layout->title = trans('messages.Edit').' '.Lang::choice('messages.Users', 1);
	    $this->layout->main = View::make('users.dashboard',compact('user'))->nest('content', 'users.edit', compact('user'));
	}

	public function deleteUser(User $user)
    {
        $user->delete();
        return Redirect::route('user.new')->with('success', Lang::choice('messages.Users', 1).' '.trans('messages.is deleted') );
    }

     public function remind()
  	 {
    	return View::make('password.remind');
  	 }

  	 public function request()
	 {
	  	$credentials = array('email' => Input::get('email'), 'password' => Input::get('password'));
	  	return Password::remind($credentials);
	 }

	 /* post functions */
    public function saveUser()
    {
        $inputs = [            
            'email'    => Input::get('email'),
            'username' => Input::get('username'),
            'password' => Input::get('password'),
            'password_confirmation' => Input::get('password_confirmation'),
            'captcha'  => Input::get('captcha'),
        ];
        $rules = [
            'email'    => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|min:8',
            'captcha'  => 'required | captcha',      
        ];

        $valid = Validator::make($inputs, $rules);
        if ($valid->passes())
        {
            if ($inputs['password'] != $inputs['password_confirmation']) 
               return Redirect::back()->withErrors( trans('messages.PACANE')  );
            $user = new User();
            $user->username = $inputs['username'];
            $user->password = Hash::make($inputs['password']);
            $user->email    = $inputs['email'];
            $user->save();
            return Redirect::route('user.new')->with('success', Lang::choice('messages.Users', 1).' '.trans('messages.is saved') );
        }
        else
            return Redirect::back()->withErrors($valid)->withInput();
    }
}