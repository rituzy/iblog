<?php
 
class Card extends Eloquent
{
    protected $fillable = array('color','content','comment','worker_id');
    
    protected $softDelete = true;

    public static $rules = [            
            'color'      => 'required',
            'content'    => 'required',            
            'worker_id'  => 'required',            
    ];

    public function worker(){
      return $this->belongsTo('Worker');
    }

    public static function getCards($pagination = 30){
      return Card::orderBy('id','desc')
                   ->paginate($pagination);
    }    
  	
}