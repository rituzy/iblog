<?php
 
class Worker extends Eloquent
{
    protected $fillable = array('name','comment');
    
    protected $softDelete = true;

    public static $rules = [
            'name'        => 'required',                        
    ];
    
    public function user(){
        return $this->belongsTo('User');
    }

    public function duties()
    {
        return $this->hasMany('Duty');
    }

    public function cards()
    {
        return $this->hasMany('Card');
    }

    public static function getWorkerOptions()
    {
        return Worker::orderBy('id','desc')
                       ->lists('name','id');
    }

}