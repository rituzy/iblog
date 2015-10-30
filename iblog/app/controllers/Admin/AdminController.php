<?php namespace Admin;

use BaseController;
use View;
use Redirect;
use Auth;
use Input;
use Validator;
use Request;

class AdminController extends BaseController {

    public function __construct(){
        $this->beforeFilter(function(){
            if(Auth::guest())
            return Redirect::to('admin/login');
        },['except' => ['getLogin','postLogin','postVKLogin']]);
    }

    public function getDashBoard()
    {
        $this->layout->content = View::make('admin.dashboard');
    }

    public function getLogin()
    {
        $this->layout->title = trans('messages.Login page');
        $this->layout->main = View::make('users.dashboard')
             ->nest('content','admin.login');
    }

    public function postLogin()
    {
        $credentials = [
            'username'=>Input::get('username'),
            'password'=>Input::get('password')
        ];
        $rules = [
            'username' => 'required',
            'password'=>'required'
        ];

        if ( \User::existsVkUserByUserName($credentials['username']) )
            return Redirect::back()->withInput()->with('failure',trans('messages.YATTUPWLV') );

        $validator = Validator::make($credentials,$rules);
        if($validator->passes())
        {
            if(Auth::attempt($credentials)){
            /*
            $layout = View::make('master');
            $layout->title = 'DashBoard';
            $layout->main = View::make('admin.dashboard')->with('content','Hi admin, Welcome to Dashboard!');
            return $layout;
            */
              if(Auth::user()->hasRole('admin'))
                return Redirect::route('admin.dash-board');

              return Redirect::to('/');
            }
            //return Redirect::route('admin.dash-board');
            return Redirect::back()->withInput()->with('failure',trans('messages.UOPII') );
        }
        else
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }
    }

    public function postVKLogin()
    {
        if(Request::ajax()) {
      
            $credentials = [                
                'username' => Input::get('FirstName'),
                'password' => 'vkPassword',
            ];
            
            $vkid = Input::get('uid');
            \User::vkUserUpsert($vkid, $credentials['username']);            

            if( Auth::attempt($credentials) )              
                return trans('messages.SLI') ; //return Redirect::to('/');
            
            return trans('messages.FTL'); 
        }

    }

    public function getLogout()
    {
        Auth::logout();
        return Redirect::to('/');
    }

}