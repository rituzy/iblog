<?php
     
class PhotoController extends BaseController
{    
    /* get functions */
    public function listPhotos()
    {
        $photos = Photo::getPhotoOrdered();
        $users  = User::all();
        $albums = Album::getAlbumsOrdered();
        $checked_albums = Album::getNames();
        $users_opt = User::getUserOptions();
        $this->layout->title = trans('messages.Photo listings');
        $this->layout->main = View::make('users.dashboard')
             ->nest('content','photos.list',compact('photos','users','albums','checked_albums','users_opt'));
    }

    public function newPhoto()
    {
        $this->layout->title = trans('messages.New').' '.Lang::choice('messages.Photos', 1);
        $albums_opt = Album::getAlbumOptions();
        $tag_opt  = Tag::getTagOptions();
        $this->layout->main = View::make('users.dashboard')
                                    ->nest('content','photos.new',
                                           ['albums_opt' => $albums_opt,
                                            'tag_opt'    => $tag_opt]);
     }
     
    public function editPhoto(Photo $photo)
    {
        $this->layout->title = trans('messages.Edit').' '.Lang::choice('messages.Photos', 1);
        $albums_opt = Album::getAlbumOptions();
        $tag_opt  = Tag::getTagOptions();
        $this->layout->main = View::make('users.dashboard')
                                    ->nest('content', 'photos.edit',
                                            compact('photo','albums_opt','tag_opt'));
    }
     
    public function deletePhoto(Photo $photo)
    {
        $photo->softDelete();
        return Redirect::route('photo.list')
                         ->with('success', Lang::choice('messages.Photos', 1).' '.trans('messages.is deleted') );
    }

    protected function getImagePath($name){
        return 'app/storage/photos/'.date('Y-m-d-H:i:s')."-".$name;
    }

    /* post functions */
    public function savePhoto()
    {
        $inputs = [            
            'photo'       => Input::file('photo'),
            'description' => Input::get('description'),
            'user_id'     => Input::get('uid'),
            'album_id'    => Input::get('album_id'),
            'name'        => Input::get('tag'),
        ];        

        $attributeNames = ['name'=>'Tag name'];
        $valid = Validator::make($inputs, Photo::$rules);
        $valid -> setAttributeNames($attributeNames);
        $valid -> sometimes('name','unique:tags|min:3|max:12',function($inputs){
            return !is_numeric( $inputs['name'] );
        });        

        if ($valid->passes())
        {            
            $photo = new Photo();            
            $photo->description = $inputs['description'];            
            $photo->user_id     = $inputs['user_id'];
            $photo->album_id    = $inputs['album_id'];
            $tag                = $inputs['name'];

            
            $image              = $inputs['photo'];
            //$filename           = $this->getImagePath($image->getClientOriginalName());
            $filename           = $image->getClientOriginalName();

            Image::make($image->getRealPath())
                   ->save(storage_path().'/photos/'.$filename);            
            $photo->image       = $filename;

            if ($tag != 'default')
                $photo->addTagOrCreateNew($tag, $inputs['user_id']);

            $photo->save();
            return Redirect::route('photo.list')
                             ->with('success', Lang::choice('messages.Photos', 1).' '.trans('messages.is saved') );
        }
        else
            return Redirect::back()
                             ->withErrors($valid)
                             ->withInput();
    }
     
    public function updatePhoto(Photo $photo)
    {
        $inputs = [            
            'photo'       => Input::file('photo'),
            'description' => Input::get('description'),
            'user_id'     => Input::get('uid'),
            'album_id'    => Input::get('album_id'),
            'name'        => Input::get('tag'),
        ];

        $attributeNames = ['name'=>'Tag name'];
        $valid = Validator::make($inputs, Photo::$rulesEdit);
        $valid -> setAttributeNames($attributeNames);
        $valid -> sometimes('name','unique:tags|min:3|max:12',function($inputs){
            return !is_numeric( $inputs['name'] );
        });

        if ($valid->passes())
        {           
            $photo->description = $inputs['description'];            
            $photo->user_id     = $inputs['user_id'];
            $photo->album_id    = $inputs['album_id'];
            $tag                = $inputs['name'];

            if ( isset($inputs['photo']) )
            {
                $image    = $inputs['photo'];
                //$filename = $this->getImagePath($image->getClientOriginalName());
                Image::make($image->getRealPath())
                        ->save(storage_path().'/photos/'.$filename);            
                $photo->image = $filename;
            }

            if ($tag != 'default')
                $photo->addTagOrCreateNew($tag, $inputs['user_id']);

            $photo->save();
            return Redirect::back()
                            ->with('success', Lang::choice('messages.Photos', 1).' '.trans('messages.is updated') );
            
        }
        else
            return Redirect::back()
                             ->withErrors($valid)
                             ->withInput();
    }
     
    public function listPhotosByAlbum()
    {   
        $checked_albums_all = Album::getNames();
        $checked_albums = $checked_albums_all;        

        foreach ($checked_albums as $name){
            $cmp_name = preg_replace('/\s+/','_', $name);            
            if (Input::get($cmp_name) != 1){              
              $key = array_search($name,$checked_albums);
              unset($checked_albums[$key]);
            }            
        }
        
        $users_opt = User::getUserOptions();
        $photos    = Photo::getPhotoByAlbum($checked_albums);
        $users     = User::all();
        $albums    = Album::getAlbumsOrdered();
        $this->layout->title = trans('messages.PLBA');
        $this->layout->main = View::make('users.dashboard')
                                    ->nest('content','photos.list',
                                        compact('photos','users','albums',
                                                'checked_albums','users_opt','inputs'));
    }

    public function listPhotosByUser()
    {   
        $checked_albums = Album::getNames();
        $uid       = Input::get('user_id');
        $photos    = Photo::getPhotoByUser($uid);
        $users     = User::all();
        $albums    = Album::getAlbumsOrdered();
        $users_opt = User::getUserOptions();
        $this->layout->title = trans('messages.PLBU');
        $this->layout->main  = View::make('users.dashboard')
                                     ->nest('content','photos.list',
                                            compact('photos','users','albums',
                                            'checked_albums','users_opt','uid'));
    }
    
    public function listPhotosByDate()
    {   
        $checked_albums = Album::getNames();
        $year      = Input::get('year');
        $month     = Input::get('month');
        $day       = Input::get('day');       
        $photos    = Photo::getPhotoYoungerThanDay($year, $month, $day);
        $users     = User::all();
        $albums    = Album::getAlbumsOrdered();
        $users_opt = User::getUserOptions();
        $this->layout->title = trans('messages.PLBD');
        $this->layout->main  = View::make('users.dashboard')
                                    ->nest('content','photos.list',
                                            compact('photos','users','albums',
                                            'checked_albums','users_opt',
                                            'year','month','day'));
    }

}
