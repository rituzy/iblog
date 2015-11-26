<?php
//file: app/controllers/BlogController.php

include(app_path().'/includes/simple_html_dom.php');

class BlogController extends BaseController
{
    /*
    public function parseSite()
    {
        // Retrieve the DOM from a given URL
        $url = 'http://www.afisha.ru/msk/cinema/';
        // инициализация сеанса
        $ch = curl_init();

        // установка URL и других необходимых параметров
        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch, CURLOPT_HEADER, 0);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        //curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        //curl_setopt($ch, CURLOPT_REFERER, $url);
        //curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0');
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // загрузка страницы и выдача её браузеру
        curl_exec($ch);

        // завершение сеанса и освобождение ресурсов
        curl_close($ch);
        $temp = $ch;

        //---------------------
        $posts = Post::getPostsOrdered();
        // For Laravel 4.2 use getFactory() instead of getEnvironment() method.
        $posts->getEnvironment()->setViewName('pagination::simple');
        $this->layout->title = 'Home Page';
        $this->layout->main = View::make('home',['recentPosts'=>$posts])
                                    ->nest('content','wa',['temp'=>$temp]);

    }
    */

    public function __construct()
    {
        //updated: prevents re-login.
        $this->beforeFilter('guest',['only' => ['getLogin']]);
        $this->beforeFilter('auth',['only' => ['getLogout']]);
    }

    public function getIndex()
    {
        $posts = Post::getPostsOrdered();
        $tags  = Tag::getTagsOrdered();
        // For Laravel 4.2 use getFactory() instead of getEnvironment() method.
        $posts->getEnvironment()->setViewName('pagination::simple');
        $this->layout->title = trans('messages.HP');
        $this->layout->main = View::make('home',['recentPosts'=>$posts, 'allTags' => $tags])
                                    ->nest('content','index',['posts'=>$posts]);
    }

    public function getSearch()
    {
        $searchTerm = Input::get('s');
        $posts    = Post::getPostsLike($searchTerm);
        $comments = Comment::getCommentsLike($searchTerm);
        $photos   = Photo::getPhotosLike($searchTerm);
        $crafts   = Craft::getCraftsLike($searchTerm);
        $tags     = Tag::getTagsOrdered();
        // For Laravel 4.2 use getFactory() instead of getEnvironment() method.
        $posts->getEnvironment()->setViewName('pagination::slider');
        $posts->appends(['s'=>$searchTerm]);
        $this->layout->with('title',trans('messages.Search').': '.$searchTerm);

        if ($posts->isEmpty())
            $notFoundPosts = true;
        else
            $notFoundPosts = false;

        if ($comments->isEmpty())
            $notFoundComments = true;
        else
            $notFoundComments = false;

        if ($photos->isEmpty())
            $notFoundPhotos = true;
        else
            $notFoundPhotos = false;

        if ($crafts->isEmpty())
            $notFoundCrafts = true;
        else
            $notFoundCrafts = false;

        $this->layout->main = View::make('home',['recentPosts'=>$posts,'allTags'=>$tags])
        ->nest('content','index_search',['posts'=>$posts, 'comments'=>$comments,'crafts'=>$crafts,
               'photos'=>$photos, 'notFoundPosts'=>$notFoundPosts,'notFoundComments'=>$notFoundComments,
               'notFoundPhotos'=>$notFoundPhotos, 'notFoundCrafts'=>$notFoundCrafts]
            );

    }

    public function getSearchFullText()
    {
        $searchTerm = Input::get('s');

        $posts = Post::whereRaw('match(title,content) against(?)',[$searchTerm])
                       ->paginate(10);
        $tags  = Tag::getTagsOrdered();
        // For Laravel 4.2 use getFactory() instead of getEnvironment() method.
        $posts->getEnvironment()->setViewName('pagination::slider');
        $posts->appends(['s'=>$searchTerm]);
        $this->layout->with('title',trans('messages.Search').': '.$searchTerm);
        $this->layout->main = View::make('home',['recentPosts'=>$posts,'allTags'=>$tags])
                                    ->nest('content','index',($posts->isEmpty()) ?
                                        ['notFound' => true ] : compact('posts'));
    }

    public function getLogin()
    {
        $this->layout->title=trans('messages.Login');
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
        $validator = Validator::make($credentials,$rules);
        if($validator->passes())
        {
            if(Auth::attempt($credentials))
            return Redirect::to('admin/dash-board');
            return Redirect::back()
                             ->withInput()
                             ->with('failure',trans('messages.inv') );
        }
        else
        {
            return Redirect::back()
                             ->withErrors($validator)
                             ->withInput();
        }
    }

    public function getLogout()
    {
        Auth::logout();
        return Redirect::to('/');
    }

    public function getDash()
    {
        $layout = View::make('master');
        $layout->title = trans('messages.AdminDashborad') ;
        $layout->main = View::make('admin.dashboard')->with('content',trans('messages.Hi admin') );
        return $layout;
    }

    public function showPhotos()
    {

        $posts = Post::getPostsOrdered();
        // For Laravel 4.2 use getFactory() instead of getEnvironment() method.
        $posts->getEnvironment()->setViewName('pagination::simple');
        $tags  = Tag::getTagsOrdered();
        $checked_albums_all = Album::getNames();
        $checked_albums = $checked_albums_all;

        $users_opt = User::getUserOptions();
        $album_ids = Album::getIdsByNames($checked_albums);
        $users     = User::all();
        $albums    = Album::getAlbumsOrdered();

        $this->layout->title = trans('messages.My Photos');
        $this->layout->main = View::make('home',['recentPosts'=>$posts,'allTags'=>$tags])
                                    ->nest('content','photos',
                                        compact('users','albums',
                                                'checked_albums','users_opt','inputs','album_ids'));
    }

    public function showCrafts()
    {

        $posts = Post::getPostsOrdered();
        // For Laravel 4.2 use getFactory() instead of getEnvironment() method.
        $posts->getEnvironment()->setViewName('pagination::simple');
        $tags  = Tag::getTagsOrdered();
        $crafts = Craft::getCraftsOrdered();

        $this->layout->title = trans('messages.My Crafts');
        $this->layout->main = View::make('home',['recentPosts'=>$posts,'allTags'=>$tags])
                                    ->nest('content','crafts',
                                        compact('crafts'));
    }

    public function showPhotosByAlbum()
    {
        $posts = Post::getPostsOrdered();
        $posts->getEnvironment()->setViewName('pagination::simple');

        $checked_albums_all = Album::getNames();
        $checked_albums = $checked_albums_all;
        $tags  = Tag::getTagsOrdered();

        foreach ($checked_albums as $name){
            $cmp_name = preg_replace('/\s+/','_', $name);
            if (Input::get($cmp_name) != 1){
              $key = array_search($name,$checked_albums);
              unset($checked_albums[$key]);
            }
        }

        $users_opt = User::getUserOptions();
        if( empty( $checked_albums ) ) $checked_albums = $checked_albums_all;
        $album_ids = Album::getIdsByNames($checked_albums);
        $users     = User::all();
        $albums    = Album::getAlbumsOrdered();
        $this->layout->title = trans('messages.PLBA');
        $this->layout->main = View::make('home',['recentPosts'=>$posts,'allTags'=>$tags])
                                    ->nest('content','photos',
                                        compact('users','albums',
                                                'checked_albums','users_opt','inputs','album_ids'));
    }

    public function showPhotosByUser()
    {
        $posts = Post::getPostsOrdered();
        $posts->getEnvironment()->setViewName('pagination::simple');
        $tags  = Tag::getTagsOrdered();

        $checked_albums = Album::getNames();
        $uid       = Input::get('user_id');
        $photos    = Photo::getPhotoByUser($uid);
        $album_ids = Photo::getAlbumIdByUser($uid);
        $users     = User::all();
        $albums    = Album::getAlbumsOrdered();
        $users_opt = User::getUserOptions();
        $this->layout->title = trans('messages.PLBU');
        $this->layout->main  = View::make('home',['recentPosts'=>$posts,'allTags'=>$tags])
                                     ->nest('content','photos',
                                            compact('photos','users','albums',
                                            'checked_albums','users_opt','uid','album_ids'));
    }

    public function showPhotosByDate()
    {
        $posts = Post::getPostsOrdered();
        $posts->getEnvironment()->setViewName('pagination::simple');

        $checked_albums = Album::getNames();
        $year      = Input::get('year');
        $month     = Input::get('month');
        $day       = Input::get('day');
        $photos    = Photo::getPhotoYoungerThanDay($year, $month, $day);
        $album_ids = Photo::getAlbumIdYoungerThanDay($year, $month, $day);
        $users     = User::all();
        $albums    = Album::getAlbumsOrdered();
        $users_opt = User::getUserOptions();
        $tags      = Tag::getTagsOrdered();
        $this->layout->title = trans('messages.PLBD');
        $this->layout->main  = View::make('home',['recentPosts'=>$posts,'allTags'=>$tags])
                                    ->nest('content','photos',
                                            compact('photos','users','albums',
                                            'checked_albums','users_opt',
                                            'year','month','day','album_ids'));
    }

}
