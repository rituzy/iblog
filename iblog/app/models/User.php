<?php
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
 
class User extends Eloquent implements UserInterface, RemindableInterface
{    
    protected $table = 'users';

    protected $softDelete = true;

    protected $hidden = array('password', 'remember_token');

    public static $rules = [
            'email'    => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|min:8',
        ];

    public static $rulesCapt = [
            'email'    => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|min:8',
            'captcha'  => 'required | captcha',      
        ];        

    public static $rulesUpd = [
            'email'    => 'required|email',
            'username' => 'required',
            'password' => 'min:8',
            'password_confirmation' => 'min:8',
        ];    
    
    //protected $hidden = ["password"];
    public static function cmpPassword($password, $confirmation){
        if ($password != $confirmation) 
               return 1;
        return 0;   
    }

    public function checkUsername($username){
        if ( $username == $this->username ) 
            return 0;

        $usr = User::where('username','=',$username)->first();        
        if (isset($usr))
            return 1;   
        else
            return 0;    
    }
    
    public function checkEmail($email){
        if ( $email == $this->email ) 
               return 0;
        $eml = User::where('email','=',$email)->first();        
        if (isset($eml))
            return 1;   
        else
            return 0;    
    }

    public static function getUserOrdered($pagination = 30){
        return User::orderBy('id','desc')
                     ->paginate($pagination);
    }

    public function getUserRoles()
    {
        return $this->roles()->get();     
    }

    public function softDelete(){
        $this->deleteUserRole();        
        $this->delete();        
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return "remember_token";
    }

    public function getReminderEmail()
    {
        return $this->email;
    }

    /**
     * Get the roles a user has
     */
    public function roles()
    {
        return $this->belongsToMany('Role', 'users_roles','user_id','role_id');
        //return $this->belongsToMany('Role');
    }

    public function albums()
    {
        return $this->hasMany('Album');
    }

    public function photos()
    {
        return $this->hasMany('Photo');
    }

    public function workers()
    {
        return $this->hasMany('Worker');
    }

    public static function getUserOptions()
    {
        return User::orderBy('id','desc')->lists('username','id');
    }
 
    /**
     * Find out if User has any role
     *
     * @return boolean
     */
    public function hasAnyRole()
    {
        $roles = $this->roles->toArray();
        return !empty($roles);
    }
 
    /**
     * Find out if user has a specific role
     *
     * $return boolean
     */
    public function hasRole($check)
    {
        return in_array($check, array_fetch($this->roles->toArray(), 'name'));
    }
 
    /**
     * Add roles to user
     */
    public function addRole($title)
    {
        /* version with multiple roles assigning
        $roles = array_fetch(Role::all()->toArray(), 'name');
 
        switch ($title) {
            case 'user':
                $assigned_roles = array('user');
            case 'admin':
                $assigned_roles = array('admin');                
            case 'family':
                $assigned_roles = array('some_role');
                break;
            default:
                throw new \Exception("The user entered does not exist");                
        }

        foreach ($assigned_roles as $role){ 
            $r = Role::where('name','=',$role)->first();            
            $this->roles()->attach($r);
        }
        */
        $role = Role::where('name','=',$title)->first();            
        $this->roles()->attach($role);

    }

    public function removeRole($title)
    {
        $role = Role::where('name','=',$title)->first();            
        $this->roles()->detach($role);
    }

    public function removeComment($title)
    {
        //todo
    }

    public function removePost($title)
    {
        //todo
    }

    public function updateUserRole($arr)
    {
        foreach($arr as $key=>$value){
            if ($value == "1")
              $this->addRole($key);
            else 
              $this->removeRole($key);
        }
    }

    public function deleteUserRole()
    {
        $roles = Role::all();
        foreach($roles as $role){
            $rname=$role->name;
            if ($this->hasRole($rname))
                $this->removeRole($rname);
        }
    }

    public static function existsVkUser($vkid)
    {
        $user = User::where('vkid','=',$vkid)->first(); 
        if ( isset($user) )
            return true;
        else
            return false;    
    }

    public static function existsVkUserByUserName($userName)
    {
        $user = User::where('username','=',$userName)
                      ->where('vkid','<>',0)
                      ->first(); 
        if ( isset($user) )
            return true;
        else
            return false;    
    }

    public static function vkUserUpsert($vkid, $vkUserName)
    {
        if ( User::existsVkUser($vkid) )
            return;   

        $user = new User();
        $user->vkid     = $vkid;
        $user->username = $vkUserName;
        $user->password = Hash::make('vkPassword');
        $user->save();

    }
  
}