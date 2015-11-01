<?php
 
class Todo extends Eloquent
{
    protected $fillable = array('content','deadline','priority','status','user_id','author_id');

    protected $softDelete = true;

    protected $attributes = array(
            'priority'  => '2',
            'status'    => '0',
    );

    public static $rules = [            
            'content' => 'required',            
            'user_id' => 'required',
            'status'  => 'required'
    ];
    /**
     * Get roles permitted to the album
     */ 
    public static function getTodosOrdered($pagination = 10)
    {
        return Todo::orderBy('id','desc')
                      ->paginate($pagination);
    }
  
    function getStatus()
    {
        if ($this->status == 1) return trans('messages.Done');
        if ($this->status == 2) return trans('messages.Fucked up');
        if ($this->status == 3) return trans('messages.Rejected');
        return trans('messages.New task');
    }
    
    public function user()
    {
        return $this->belongsTo('User');
    }
    /* if we decide to use roles for accessing todo lists of different users
    public function isAllowedUser($user_id){
        $user = User::where('id','=',$user_id)->first();
        foreach($this->roles as $role)
          if(in_array($role->name, array_fetch($user->roles->toArray(), 'name')))
            return true;
        return false;
    }
    */
}