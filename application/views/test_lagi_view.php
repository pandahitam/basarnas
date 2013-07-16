<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  // Set timezone
  date_default_timezone_set("UTC");
 
  // Time format is UNIX timestamp or
  // PHP strtotime compatible strings
  function dateDiff($time1, $time2, $precision = 6) {
    // If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) {
      $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
      $time2 = strtotime($time2);
    }
 
    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
      $ttime = $time1;
      $time1 = $time2;
      $time2 = $ttime;
    }
 
    // Set up intervals and diffs arrays
    $intervals = array('year','month','day','hour','minute','second');
    $diffs = array();
 
    // Loop thru all intervals
    foreach ($intervals as $interval) {
      // Set default diff to 0
      $diffs[$interval] = 0;
      // Create temp time from time1 and interval
      $ttime = strtotime("+1 " . $interval, $time1);
      // Loop until temp time is smaller than time2
      while ($time2 >= $ttime) {
				$time1 = $ttime;
				$diffs[$interval]++;
				// Create new temp time from time1 and interval
				$ttime = strtotime("+1 " . $interval, $time1);
      }
    }
 
    $count = 0;
    $times = array();
    // Loop thru all diffs
    foreach ($diffs as $interval => $value) {
      // Break if we have needed precission
      if ($count >= $precision) {
				break;
      }
      // Add value and interval 
      // if value is bigger than 0
      if ($value > 0) {
				// Add s if value is not 1
				if ($value != 1) {
	  			$interval .= "s";
				}
				// Add value and interval to times array
				$times[] = $value . " " . $interval;
				$count++;
      }
    }
 
    // Return string with times
    return implode(", ", $times);
  }

  function dateDiff_2($time1, $time2, $precision = 6) {
    // If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) {
      $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
      $time2 = strtotime($time2);
    }
 
    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
      $ttime = $time1;
      $time1 = $time2;
      $time2 = $ttime;
    }
 
    // Set up intervals and diffs arrays
    $intervals = array('year');
    $diffs = array();
 
    // Loop thru all intervals
    foreach ($intervals as $interval) {
      // Set default diff to 0
      $diffs[$interval] = 0;
      // Create temp time from time1 and interval
      $ttime = strtotime("+1 " . $interval, $time1);
      // Loop until temp time is smaller than time2
      while ($time2 >= $ttime) {
				$time1 = $ttime;
				$diffs[$interval]++;
				// Create new temp time from time1 and interval
				$ttime = strtotime("+1 " . $interval, $time1);
      }
    }
 
    // Return string with times
    return implode(", ", $diffs);
  }

/*
echo dateDiff_2("2010-01-26", "2004-01-26") . "<br>";
echo dateDiff_2("2011-01-30", "2012-01-26") . "<br>";
echo dateDiff_2("2006-04-12 12:30:00", "1987-04-12 12:30:01") . "<br>";
echo dateDiff_2("now", "now +2 months") . "<br>";
echo dateDiff_2("now", "now -6 year -2 months -10 days") . "<br>";
echo dateDiff_2("2009-01-26", "2004-01-26 15:38:11") . "<br>";
*/
$find = "345.ZZZ/KPTS.XXX.BKPPD/YYY";
$search = array("ZZZ","XXX","YYY");
$replace = array("4","123","2012");
$hasil = str_replace($search,$replace,$find);
echo $hasil;
?>