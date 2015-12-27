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
/*
    Route::matched(function($route, $request) {

      if($route->getName() != 'route_not_translate') { // don't do it for exclusive area

        $language = 'en'; //english is fallback locale
        $lgs = ['ru','en'];

        // get the default browser language with the $request object
        $browserLg = substr($request->server->get('HTTP_ACCEPT_LANGUAGE'), 0, 2);

        //these to strings should be removed if you uncomment next block of parsing address
        if(in_array($browserLg, $lgs))
            $language = $browserLg;

        //block of parsing address is not needed as all pages have the same address for both languages

        // language set from route (for example /en/some-url)
        $requestLg = $request->segment(1);

        # if the language called in url request matches your set of languages
        if (null !== $requestLg && in_array($requestLg, $lgs)) {

                $language = $requestLg;

        # default browser lg
        } else {

            if(in_array($browserLg, $lgs)) {

                $language = $browserLg;
            }

      }

      // set the validated language
      $_ENV['LOCALE'] = $language;
      Config::set('locale',$language);
      App::setLocale($language);

      // share it with views if you want
      View::share('locale', $language);

    });
*/
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
