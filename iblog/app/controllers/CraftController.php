<?php
     
class CraftController extends BaseController
{    
    /* get functions */
    public function listCrafts()
    {
        $crafts = Craft::getCraftsOrdered();
        $this->layout->title = trans('messages.Craft listings');
        $this->layout->main = View::make('users.dashboard')
             ->nest('content','crafts.list',compact('crafts'));
    }

    public function viewCraft(Craft $craft)
    {
        if(Request::ajax())
            return View::make('crafts.view',compact('craft'));   
    }

    public function newCraft()
    {
        $this->layout->title = trans('messages.New').' '.Lang::choice('messages.Crafts', 1);
        $tag_opt  = Tag::getTagOptions();
        $this->layout->main = View::make('users.dashboard')
                                    ->nest('content','crafts.new',
                                           ['tag_opt'    => $tag_opt]);
     }
     
    public function editCraft(Craft $craft)
    {
        $this->layout->title = trans('messages.Edit').' '.Lang::choice('messages.Crafts', 1);
        $tag_opt  = Tag::getTagOptions();
        $this->layout->main = View::make('users.dashboard')
                                    ->nest('content', 'crafts.edit',
                                            compact('craft','tag_opt'));
    }
     
    public function deleteCraft(Craft $craft)
    {
        $craft->delete();
        return Redirect::route('craft.list')
                         ->with('success', Lang::choice('messages.Crafts', 1).' '.trans('is deleted') );
    }
    
    /* post functions */
    public function saveCraft()
    {
        $inputs = [            
            'title'          => Input::get('title'),
            'description'    => Input::get('description'),
            'title_ru'       => Input::get('title_ru'),
            'description_ru' => Input::get('description_ru'),
            'link'           => Input::get('link'),
            'image'          => Input::file('image'),
            'user_id'        => Input::get('uid'),
            'name'           => Input::get('tag'),
        ];        

        $attributeNames = ['name'=>'Tag name'];
        $valid = Validator::make($inputs, Craft::$rules);
        $valid -> setAttributeNames($attributeNames);
        $valid -> sometimes('name','unique:tags|min:3|max:12',function($inputs){
            return !is_numeric( $inputs['name'] );
        });        

        if ($valid->passes())
        {            
            $craft = new Craft();            
            $craft->title       = $inputs['title'];            
            $craft->description = $inputs['description'];            
            $craft->title_ru    = $inputs['title_ru'];
            $craft->description_ru = $inputs['description_ru'];
            $craft->link        = $inputs['link'];
            $craft->user_id     = $inputs['user_id'];            
            $tag                = $inputs['name'];            
            
            $image              = $inputs['image'];
            if (isset($image)) {
                list($width, $height) = getimagesize($image);
                $ratio = $height/$width;
                $filename = date('Y-m-d-H:i:s')."-".$image->getClientOriginalName();
                $width = ($width>600)?600:$width;
                $height = ($height>600)? $width*$ratio :$height;
                Image::make($image->getRealPath())->resize($width,$height)
                       ->save(public_path().'/img/pncpictures/'.$filename);
                $craft->image = 'img/pncpictures/'.$filename;
            } else
                $craft->image = '';

            if ($tag != 'default')
                $craft->addTagOrCreateNew($tag, $inputs['user_id']);

            $craft->save();
            return Redirect::route('craft.list')
                             ->with('success', Lang::choice('messages.Crafts', 1).' '.trans('is saved') );
        }
        else
            return Redirect::back()
                             ->withErrors($valid)
                             ->withInput();
    }
     
    public function updateCraft(Craft $craft)
    {
        $inputs = [            
            'title'          => Input::get('title'),
            'description'    => Input::get('description'),
            'title_ru'       => Input::get('title_ru'),
            'description_ru' => Input::get('description_ru'),            
            'link'           => Input::get('link'),
            'image'          => Input::file('image'),
            'user_id'        => Input::get('uid'),
            'name'           => Input::get('tag'),
        ];

        $attributeNames = ['name'=>'Tag name'];
        $valid = Validator::make($inputs, Craft::$rules);
        $valid -> setAttributeNames($attributeNames);
        $valid -> sometimes('name','unique:tags|min:3|max:12',function($inputs){
            return !is_numeric( $inputs['name'] );
        });        

        if ($valid->passes())
        {           
            $craft->title          = $inputs['title'];            
            $craft->description    = $inputs['description'];
            $craft->title_ru       = $inputs['title_ru'];
            $craft->description_ru = $inputs['description_ru']; 
            $craft->link           = $inputs['link'];
            $craft->user_id        = $inputs['user_id'];            
            $tag                   = $inputs['name'];

            $image                 = $inputs['image'];
            if (isset($image)) {
                list($width, $height) = getimagesize($image);
                $ratio = $height/$width;
                $filename = date('Y-m-d-H:i:s')."-".$image->getClientOriginalName();
                $width = ($width>600)?600:$width;
                $height = ($height>600)? $width*$ratio :$height;
                Image::make($image->getRealPath())->resize($width,$height)
                       ->save(public_path().'/img/pncpictures/'.$filename);
                $craft->image = 'img/pncpictures/'.$filename;
            } else
                $craft->image = '';

            if ($tag != 'default')
                $craft->addTagOrCreateNew($tag, $inputs['user_id']);

            $craft->save();
            return Redirect::back()
                            ->with('success', Lang::choice('messages.Crafts', 1).' '.trans('is updated'));
            
        }
        else
            return Redirect::back()
                             ->withErrors($valid)
                             ->withInput();
    }
    
}
