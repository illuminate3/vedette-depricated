<?php namespace Vedette\helpers;

class Globals {

  /**
   * This function will be used to spit out the variable dump.
   * It takes two parameters, one is the array / variable
   * and the second is flag for exit.
   * @param  array  $var  [array or variable]
   * @param  boolean $exit [should continue or exit]
   * @return none
   */
  public static function dsm($var, $exit = false)
  {
    print '<pre>';
    print_r($var);
    print '</pre>';

    if ($exit ===  true)
      exit;
  }

  public static function last_insert_id()
  {
    return DB::getPdo()->lastInsertId();
  }

  public static function last_query($query = false)
  {
    $queries = DB::getQueryLog();
    $last_query = end($queries);
    if ($query)
      return $last_query['query'];
    else
      return $last_query;
  }

  public static function fetchCacheData($name)
  {
    $cache = Cache::get($name);
    if ($cache)
    {
      return $cache;
    }
    else
    {
      return false;
    }
  }

  public static function getCacheIfPresent($cacheId)
  {
    if (Config::get('app.caching') == 'true')
    {
      $value = Cache::get($cacheId);

      if ($value)
      {
        return $value;
      }
      else
        return false;
    }
    else
    {
      return false;
    }
  }

  public static function setMessage($message, $flag = 'info')
  {
    $tempMessage = '';
    if (Session::get('message'))
      $tempMessage = Session::get('message');

    $tempMessage = $tempMessage . '<li>' . $message . '</li>';
    Session::flash('message', $tempMessage);
    Session::flash('message-flag', $flag);
  }

  /**
   * This function will return
   * @param int $count
   * @return mixed
   */
  public static function getURLSegment($count = 0)
  {
    $uri = Request::path();
    $uri = explode('/', $uri);
    return $uri[$count];
  }

  /**
   * This function will take a time stamp and calculate time ago.
   *
   * @param $time_ago
   * @return string
   */
  public static function timeAgo($time_ago)
  {
    $cur_time 	= time();
    $time_elapsed 	= $cur_time - $time_ago;
    $seconds 	= $time_elapsed ;
    $minutes 	= round($time_elapsed / 60 );
    $hours 		= round($time_elapsed / 3600);
    $days 		= round($time_elapsed / 86400 );
    $weeks 		= round($time_elapsed / 604800);
    $months 	= round($time_elapsed / 2600640 );
    $years 		= round($time_elapsed / 31207680 );

    $result = "";
    // Seconds
    if($seconds <= 60)
    {
      $result = "$seconds seconds ago";
    }
    //Minutes
    else if($minutes <=60)
    {
      if($minutes==1)
        $result = "one minute ago";
      else
        $result = "$minutes minutes ago";
    }
    //Hours
    else if($hours <=24)
    {
      if($hours==1)
        $result = "an hour ago";
      else
        $result = "$hours hours ago";
    }
    //Days
    else if($days <= 7)
    {
      if($days==1)
        $result = "yesterday";
      else
        $result = "$days days ago";
    }
    //Weeks
    else if($weeks <= 4.3)
    {
      if($weeks==1)
        $result = "a week ago";
      else
        $result = "$weeks weeks ago";
    }
    //Months
    else if($months <=12)
    {
      if($months==1)
        $result = "a month ago";
      else
        $result = "$months months ago";
    }
    //Years
    else
    {
      if($years==1)
        $result = "one year ago";
      else
        $result = "$years years ago";
    }
    return $result;
  }


  public static function checkAuth ()
    {
        $auth = Session::get('checkAuth');
        if ($auth == 'true')
            return true;
        else
            return false;
    }
}