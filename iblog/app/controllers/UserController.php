<?php
     
class UserController extends BaseController
{
    protected function isPostRequest()
    {
            return Input::server("REQUEST_METHOD") == "POST";
    }
    
    /* get functions */
    public function listUserView($view)
    {
        $users = User::getUserOrdered();
        $roles = Role::getRolesOrdered();
        $this->layout->title = trans('messages.User listings');
        $this->layout->main = View::make($view)
                                    ->nest('content','users.list',compact('users','roles'));
    }

    public function showUserView(User $user, $view)
    {
        $roles = $user->getUserRoles(); 
        $this->layout->title = $user->username;        
        $this->layout->main = View::make($view)
                                    ->nest('content','users.single',compact('user','roles'));        
    }
     
    public function newUserView($view)
    {
        $this->layout->title = trans('messages.New').' '.Lang::choice('messages.Users', 1);
        $this->layout->main = View::make($view)
                                    ->nest('content','users.new');
     }
     
    public function editUserView(User $user, $view)
    {
        $this->layout->title = trans('messages.Edit').' '.Lang::choice('messages.Users', 1);
        $this->layout->main = View::make($view)
                                    ->nest('content', 'users.edit', compact('user'));
    }
     
    public function deleteUserView(User $user, $view)
    {        
        $user->softDelete();
        if ($view == 'logout'){
            Auth::logout($user);
            return Redirect::to('/');
        }
        return Redirect::route($view)
                         ->with('success', Lang::choice('messages.Users', 1).' '.trans('messages.is deleted') );
    }    

    /* post functions */
    public function saveUserCapt()
    {
        $inputs = [            
            'email'    => Input::get('email'),
            'username' => Input::get('username'),
            'password' => Input::get('password'),
            'password_confirmation' => Input::get('password_confirmation'),
            'captcha'  => Input::get('captcha'),
        ];        

        if (User::cmpPassword($inputs['password'], $inputs['password_confirmation']) == 1) 
               return Redirect::back()
                                ->withErrors( trans('messages.PACANE') );

        $valid = Validator::make($inputs, User::$rulesCapt);
        if ($valid->passes())
        {
            $user = new User();
            $user->username = $inputs['username'];
            $user->password = Hash::make($inputs['password']);
            $user->email    = $inputs['email'];
            $user->save();
            return Redirect::route('user.new')->with('success', Lang::choice('messages.Users', 1).' '.trans('messages.is saved'));
        }
        else
            return Redirect::back()->withErrors($valid)->withInput();
    }


    public function saveUser()
    {
        $inputs = [            
            'email'    => Input::get('email'),
            'username' => Input::get('username'),
            'password' => Input::get('password'),
            'password_confirmation' => Input::get('password_confirmation'),
        ];
        
        if (User::cmpPassword($inputs['password'], $inputs['password_confirmation']) == 1) 
               return Redirect::back()
                                ->withErrors( trans('messages.PACANE') );

        $valid = Validator::make($inputs, User::$rules);
        if ($valid->passes())
        {            
            $user = new User();
            $user->username = $inputs['username'];
            $user->password = Hash::make($inputs['password']);
            $user->email    = $inputs['email'];
            $user->save();
            return Redirect::route('user.new')
                             ->with('success',  Lang::choice('messages.Users', 1).' '.trans('messages.is saved') );
        }
        else
            return Redirect::back()
                             ->withErrors($valid)
                             ->withInput();
    }
     
    public function updateUser(User $user)
    {
        $inputs = [
            'email'    => Input::get('email'),
            'username' => Input::get('username'),
            'password' => Input::get('password'),
            'password_confirmation' => Input::get('password_confirmation'),
        ];
        
        $valid = Validator::make($inputs, User::$rulesUpd);

        if (User::cmpPassword($inputs['password'], $inputs['password_confirmation']) == 1) 
               return Redirect::back()
                                ->withErrors( trans('messages.PACANE') );

        if ( isset($inputs['username'] ) && 
                  $user->checkUsername( $inputs['username'] ) == 1 )
               return Redirect::back()
                                ->withErrors( trans('messages.TUAXTAO') );            
     
        if ( isset($inputs['email'] ) && 
                  $user->checkEmail( $inputs['email'] ) == 1 )
               return Redirect::back()
                                ->withErrors( trans('messages.TEAXTAO') );            
     
        if ($valid->passes())
        {            
            $user->username = $inputs['username'];
            $user->email    = $inputs['email'];
            if ( isset($inputs['password']) && $inputs['password'] != '' )
                $user->password = Hash::make($inputs['password']);

            $user->save();
            return Redirect::back()->with('success',  Lang::choice('messages.Users', 1).' '.trans('messages.is updated'));            
        }
        else
            return Redirect::back()->withErrors($valid)->withInput();
    }
     
    public function updateUserRole(User $user)
    {        
        $inputs = Input::except('_token');
        $user->updateUserRole($inputs);
        return Redirect::back()
                         ->with('success', trans('messages.RFUS') );
    } 
}
