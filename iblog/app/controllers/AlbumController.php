<?php
     
class AlbumController extends BaseController
{
    /* get functions */
    public function listAlbums()
    {
        $albums = Album::getAlbumsOrdered();
        $users = User::all();
        $roles = Role::getRolesOrdered();
        $this->layout->title = trans('messages.Album listings');
        $this->layout->main = View::make('users.dashboard')->nest('content','albums.list',compact('albums','users','roles'));
    }
     
    public function newAlbum()
    {
        $this->layout->title = trans('messages.New').' '.Lang::choice('messages.Albums', 1);
        $this->layout->main = View::make('users.dashboard')->nest('content','albums.new');
     }
     
    public function editAlbum(Album $album)
    {
        $this->layout->title = trans('messages.Edit').' '.Lang::choice('messages.Albums', 1);
        $this->layout->main = View::make('users.dashboard')->nest('content', 'albums.edit', compact('album'));
    }
     
    public function deleteAlbum(Album $album)
    {
        $album->softDelete();
        return Redirect::route('album.list')->with('success', Lang::choice('messages.Albums', 1).' '.trans('messages.is deleted'));
    }
     
    /* post functions */
    public function saveAlbum()
    {
        $inputs = [            
            'name' => Input::get('name'),
            'description' => Input::get('description'),
            'user_id' => Input::get('uid'),
        ];        

        $valid = Validator::make($inputs, Album::$rules);
        if ($valid->passes())
        {            
            $album              = new Album();
            $album->name        = $inputs['name'];
            $album->description = $inputs['description'];            
            $album->user_id     = $inputs['user_id'];
            $album->save();
            return Redirect::route('album.list')
                             ->with('success', Lang::choice('messages.Albums', 1).' '.trans('messages.is saved') );
        }
        else
            return Redirect::back()
                             ->withErrors($valid)
                             ->withInput();
    }
     
    public function updateAlbum(Album $album)
    {
        $inputs = [            
            'name' => Input::get('name'),
            'description' => Input::get('description'),
            'user_id' => Input::get('uid'),
        ];
    
        $valid = Validator::make($inputs, Album::$rules);
        if ($valid->passes())
        {           
            $album->name        = $inputs['name'];
            $album->description = $inputs['description'];
            $album->user_id     = $inputs['user_id'];            
            if(count($album->getDirty()) > 0) /* avoiding resubmission of same content */
            {
                $album->save();
                return Redirect::back()
                                 ->with('success', Lang::choice('messages.Albums', 1).' '.trans('messages.is updated'));
            }
            else
                return Redirect::back()
                                 ->with('success',trans('messages.Nothing to update') );
        }
        else
            return Redirect::back()
                             ->withErrors($valid)
                             ->withInput();
    }

    public function updateAlbumRole(Album $album)
    {        
        $inputs = Input::except('_token');
        $album->updateAlbumRole($inputs);
        return Redirect::back()
                         ->with('success',trans('messages.Role for album saved') );
    }
     
}
