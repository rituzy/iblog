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

    public function getMonth()
    {
      switch ($this->month) {
        case 1:
          return 'January';
          break;
        case 2:
          return 'February';
          break;
        case 3:
          return 'March';
          break;
        case 4:
          return 'April';
          break;
        case 5:
          return 'May';
          break;
        case 6:
          return 'June';
          break;
        case 7:
          return 'July';
          break;
        case 8:
          return 'August';
          break;
        case 9:
          return 'September';
          break;
        case 10:
          return 'October';
          break;
        case 11:
          return 'November';
          break;
        case 12:
          return 'December';
          break;
        default:
          return 'Unknown month!';
          break;
      }
    }
    public static function getDutiesOrderedFill($pagination = 30)
    {
      return Duty::where('monthPart','=',0)
                   ->orderBy('year','desc')
                   ->orderBy('month','desc')
                   ->paginate($pagination);
    }

    public static function getDutiesOrderedUpd($pagination = 30)
    {
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

  		return Duty::whereIn('year',[$year-1,$year,$year+1])
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



      return Duty::whereIn('year',[$year-1,$year,$year+1])
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
