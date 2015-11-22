<?php

class Photo extends Eloquent
{
    protected $fillable = array('image','description','user_id','album_id');

    protected $softDelete = true;

    public static $rules = [
            'photo'    => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:3000',
            'user_id'  => 'required',
            'album_id' => 'required',
    ];

    public static $rulesEdit = [
            'photo'    => 'image|mimes:jpeg,jpg,bmp,png,gif|max:3000',
            'user_id'  => 'required',
            'album_id' => 'required',
    ];

    public function user(){
        return $this->belongsTo('User');
    }

    public function album(){
        return $this->belongsTo('Album');
    }

    public function tags()
    {
        return $this->morphToMany('Tag', 'taggable');
    }
    /**
	 * Get photo for photo
	 *
	 * @return string
	 */
  	public function getPhotoImage()
  	{
  	    if(!empty($this->image) && File::exists(storage_path().'/photos/'.$this->image))
  	    {

  	        // Get the filename from the full path
  	        $filename = basename(storage_path().'/photos/'.$this->image);

  	        return 'img/image.php?imageid='.$filename;
  	    }

  	    return 'img/missing.png';
  	}

  	/**
  	* Get photos ordered
  	*
  	*/
  	public static function getPhotoOrdered($pagination = 30){
  		return Photo::orderBy('id','desc')->paginate($pagination);
  	}

  	public static function getPhotoByAlbum($checked_albums, $pagination = 30){
  		$album_ids = Album::getIdByName($checked_albums);
  		return Photo::whereIn('album_id',$album_ids)
                        ->orderBy('id','desc')->paginate($pagination);
  	}

  	public static function getPhotoByUser($userId, $pagination = 30)
    {
  		if ($userId == 'all')
              return Photo::orderBy('id','desc')
                            ->paginate($pagination);
          else
              return Photo::where('user_id','=',$userId)
                            ->orderBy('id','desc')
                            ->paginate($pagination);
  	}

    public static function getPhotosLike($searchItem, $pagination = 10)
    {
        $searchItem = '%'.$searchItem.'%';

        return Photo::where('description','LIKE', $searchItem)
                        ->paginate($pagination);
    }

    public static function getAlbumIdByUser($userId)
    {
      if ($userId == 'all')
              return Album::lists('id');
          else
              return Photo::where('user_id','=',$userId)
                            ->lists('album_id');
    }

  	public static function getPhotoYoungerThanDay($year, $month, $day, $pagination = 30)
    {
  		$day = Photo::checkDay($year,$month,$day);

  		return Photo::where(function($query) use ($year,$month, $day){
                           $query->where(DB::raw('YEAR(created_at)'),'>',$year)
                                 ->orWhere(function($iq)use ($year,$month, $day){
                                  $iq->where(DB::raw('YEAR(created_at)'),'=', $year)
                                     ->where(DB::raw('MONTH(created_at)'),'>', $month)
                                     ->orWhere(function($iiq) use ($year,$month, $day){
                                          $iiq->where(DB::raw('YEAR(created_at)'),'=', $year)
                                              ->where(DB::raw('MONTH(created_at)'),'=',$month)
                                              ->where(DB::raw('DAYOFMONTH(created_at)'),'>=',$day);
                                     });
                                 });
                             })->orderBy('id','desc')->paginate($pagination);
  	}

    public static function getAlbumIdYoungerThanDay($year, $month, $day, $pagination = 30)
    {
      $day = Photo::checkDay($year,$month,$day);

      return Photo::where(function($query) use ($year,$month, $day){
                           $query->where(DB::raw('YEAR(created_at)'),'>',$year)
                                 ->orWhere(function($iq)use ($year,$month, $day){
                                  $iq->where(DB::raw('YEAR(created_at)'),'=', $year)
                                     ->where(DB::raw('MONTH(created_at)'),'>', $month)
                                     ->orWhere(function($iiq) use ($year,$month, $day){
                                          $iiq->where(DB::raw('YEAR(created_at)'),'=', $year)
                                              ->where(DB::raw('MONTH(created_at)'),'=',$month)
                                              ->where(DB::raw('DAYOFMONTH(created_at)'),'>=',$day);
                                     });
                                 });
                             })->lists('album_id');
    }

  	protected static function checkDay($year, $month, $day)
    {
      $max_days = 31;
      $thirty_days = [4,6,9,11];
      $feb = 2;

      if (in_array($month,$thirty_days))  $max_days = 30;
      if ($month == $feb && $year%4 != 0) $max_days = 28;
      if ($month == $feb && $year%4 == 0) $max_days = 29;
      if ($day > $max_days) return $max_days;
      return $day;
    }

    public function softDelete(){
     	$this->delete();
    }

    public function hardDelete(){
    	File::delete($this->image);
    	$this->delete();
    }

    public function getCreatorName(){
      $users = User::getUserOrdered();
      foreach($users as $user)
        if($user->id == $this->user_id)
          return $user->username;
      return trans('messages.Deleted');
    }

    public function getAlbumName(){
      $album = Album::where('id','=',$this->album_id)->first();
      return $album->name;
    }

    public function addTagOrCreateNew($tag,$user_id = 0)
    {
        $tagFound = Tag::where('id','=',$tag)->first();

        if (!isset($tagFound)){
            $tagFound = new Tag;
            $tagFound->name = $tag;
            $tagFound->user_id = $user_id;
            $tagFound->save();
        }

        $tagFound->photos()->save($this);
    }
}
