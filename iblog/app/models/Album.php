<?php
 
class Album extends Eloquent
{
    protected $fillable = array('name','description','user_id');

    protected $softDelete = true;

    public static $rules = [            
            'name' => 'required|unique:albums',
            'user_id' => 'required',
    ];
    /**
     * Get roles permitted to the album
     */
    public function roles()
    {
        return $this->belongsToMany('Role', 'albums_roles','album_id','role_id');        
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function photos()
    {
        return $this->hasMany('Photo');
    }

    public function tags()
    {
        return $this->morphToMany('Tag', 'taggable');
    }
 
    public static function getNames()
    {
        return Album::lists('name');
    }

    public static function getIdByName($names)
    {
        if (empty($names)) $names = Album::getNames();
        return Album::whereIn('name',$names)
                      ->lists('id');
    }

    public static function getAlbumOptions()
    {
        return Album::orderBy('id','desc')
                      ->lists('name','id');
    }

    public static function getAlbumsOrdered($pagination = 10)
    {
        return Album::orderBy('id','desc')
                      ->paginate($pagination);
    }

    public function softDelete(){
        $this->delete();
    }

    public function hasRole($check)
    {
        return in_array($check, array_fetch($this->roles->toArray(), 'name'));
    }


    public function updateAlbumRole($arr)
    {
        foreach($arr as $key=>$value){
            if ($value == "1")
              $this->addRole($key);
            else 
              $this->removeRole($key);
        }
    }

    public function addRole($title)
    {
        $role = Role::where('name','=',$title)->first();            
        $this->roles()->attach($role);
    }

    public function removeRole($title)
    {
        $role = Role::where('name','=',$title)->first();            
        $this->roles()->detach($role);
    }

    public static function getIdsByNames($names)
    {   
        if ( !empty($names) )    
            return Album::whereIn('name',$names)
                          ->lists('id');
        else
            return 0;
    }

    public function isAllowedUser($user_id){
        $user = User::where('id','=',$user_id)->first();
        foreach($this->roles as $role)
          if(in_array($role->name, array_fetch($user->roles->toArray(), 'name')))
            return true;
        return false;
    }
}