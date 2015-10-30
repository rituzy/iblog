<?php
 
class Duty extends Eloquent
{
    protected $fillable = array('monthPart','month','year','worker_id','comment');
    
    protected $softDelete = true;

    public static $rules = [            
            'monthPart'  => 'required|min:0|max:2',
            'month'      => 'required|min:1|max:12',
            'year'       => 'required',
            'worker_id'  => 'required',            
    ];

    public function worker(){
      return $this->belongsTo('Worker');
    }

    public static function getDutiesOrderedFill($pagination = 30){
      return Duty::where('monthPart','=',0)
                   ->orderBy('year','desc')
                   ->orderBy('month','desc')
                   ->paginate($pagination);
    }

    public static function getDutiesOrderedUpd($pagination = 30){
      return Duty::whereIn('monthPart',[1,2])
                   ->orderBy('year','desc')
                   ->orderBy('month','desc')
                   ->orderBy('monthPart','desc')
                   ->paginate($pagination);
    }

  	public static function getDutiesUpd($pagination = 30)
    {

      $year  = date("Y");
      $month = date("m");
      $day   = date("d");

      $month += 4;

      if ($month > 12){ 
        $month -= 12;
        $yearBefore = $year--;        
      }
      else 
        $yearBefore = $year;
      
      $monthBegin = $month - 7;
      if ($monthBegin < 0)
        $monthBegin += 12;

  		return Duty::whereIn('year',[$year,$yearBefore])
                   ->where(function($query) use ($month, $monthBegin){
                        $query->where('month','<',$month)
                              ->orWhere('month','>',$monthBegin);
                    })
                   ->whereIn('monthPart',[1,2])
                   ->orderBy('year','desc')
                   ->orderBy('month','desc')
                   ->orderBy('monthPart','desc')
                   ->paginate($pagination);

  	}

    public static function getDutiesFill($pagination = 30)
    {

      $year  = date("Y");
      $month = date("m");
      $day   = date("d");

      $month += 4;

      if ($month > 12){ 
        $month -= 12;
        $yearBefore = $year--;        
      }
      else 
        $yearBefore = $year;
      
      $monthBegin = $month - 7;
      if ($monthBegin < 0)
        $monthBegin += 12;

      return Duty::whereIn('year',[$year,$yearBefore])
                   ->where(function($query) use ($month, $monthBegin){
                        $query->where('month','<',$month)
                              ->orWhere('month','>',$monthBegin);
                    })
                   ->where('monthPart','=',0)
                   ->orderBy('year','desc')
                   ->orderBy('month','desc')                   
                   ->paginate($pagination);

    }

  	protected static function getNowUpd()
    {
      $year  = date("Y");
      $month = date("m");
      $day   = date("d");

      if ($day > 15) 
        $monthPart = 2;
      else 
        $monthPart = 1;      

      $current = Duty::where('year','=',$year)
                       ->where('month','=',$month)
                       ->where('monthPart','=',$monthPart)                       
                       ->first();
      
      if (isset($current))
        return $current;
      else 
        return Duty::all()->first();
    }

    protected static function getNowFill()
    {
      $year  = date("Y");
      $month = date("m");
      
      $current = Duty::where('year','=',$year)
                       ->where('month','=',$month)
                       ->where('monthPart','=',0)                       
                       ->first();
      
      if (isset($current))
        return $current;
      else 
        return Duty::all()->first();
    }

}