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

    public static function getTodosActual($pagination = 10)
    {
        return Todo::where('status','=','0')
                     ->orderBy('id','desc')
                     ->paginate($pagination);
    }

    public static function getTodosNotActual($pagination = 10)
    {
        return Todo::where('status','<>','0')
                     ->orderBy('id','desc')
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

    public function sendNotification($mes)
    {
        $user = User::findUserByID($this->user_id);
        if( isset($user) && isset($user->email) && $user->email <> '' ) {
          Mail::send('emails.TodoCreated', ['content'=>$this->content,
          'priority'=>$this->priority,'deadline'=>$this->deadline,'mes'=>$mes],
            function($message) use($user,$mes)
            {
                $message->to($user->email, $user->username)->subject($mes);
            });
        }
    }

    public static function getFilteredTodosByFlag($flag)
    {
        if ($flag == 1)
          return Todo::getTodosActual();
          
        if ($flag == 2)
          return Todo::getTodosNotActual();

        return Todo::getTodosOrdered();
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
