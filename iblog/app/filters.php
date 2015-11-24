<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
    Input::merge(array_strip_tags(Input::all()));
	  // Set default locale.
    $mLocale = Config::get( 'app.locale' );
    // Has a session locale already been set?
    if ( !Session::has( 'locale' ) )
    {
        // No, a session locale hasn't been set.
        // Was there a cookie set from a previous visit?
        $mFromCookie = Cookie::get( 'locale', null );
        if ( $mFromCookie != null && in_array( $mFromCookie, Config::get( 'app.locales' ) ) )
        {
            // Cookie was previously set and it's a supported locale.
            $mLocale = $mFromCookie;
        }
        else
        {
            // attempt to detect locale from browser.
            $mFromBrowser = substr( Request::server( 'http_accept_language' ), 0, 2 );
            if ( $mFromBrowser != null && in_array( $mFromBrowser, Config::get( 'app.locales' ) ) )
            {
                // browser lang is supported, use it.
                $mLocale = $mFromBrowser;
            } // $mFromBrowser
        } // $mFromCookie
        Session::put( 'locale', $mLocale );
        Cookie::forever( 'locale', $mLocale );
    } // Session?
    else
    {
        // session locale is available, use it.
        $mLocale = Session::get( 'locale' );
    } // Session?
    // set application locale for current session.
    App::setLocale( $mLocale );
    
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

/*
|-------------------------------------------------------------------------
|Role Filters
|-------------------------------------------------------------------------
*/
Route::filter('role_admin',function()
{
	if (!Auth::user()->hasRole('admin'))
	{
		return Redirect::to('/');//return Response::make('Unauthorized',401);
	}
}
);
