<?php
 
class Role extends Eloquent
{
    protected $fillable = array('name');

    protected $softDelete = true;

    public static $rules = [            
            'name' => 'required|unique:roles',
        ];
    /**
     * Set timestamps off
     */
    //public $timestamps = false;
 
    public function users()
    {
        return $this->belongsToMany('User', 'users_roles','role_id','user_id');
        
    }

    public function albums()
    {
        return $this->belongsToMany('Album', 'albums_roles','role_id','album_id');        
    }

    public static function getRolesOrdered($pagination = 10)
    {
        return Role::orderBy('id','desc')
                     ->paginate($pagination);
    }

    public function softDelete()
    {
        $this->delete();        
    }
}