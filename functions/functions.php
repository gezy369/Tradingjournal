<?php
// ----------------------------------------------------------------------------------- //
// This function will check if the given date is a weekend or weekday, and return
// the result. It is used in the Trade Journal table.
// ----------------------------------------------------------------------------------- //
function check_weekend($daytocheck,$monthtocheck,$yeartocheck){

   //Date in YYYY-MM-DD format.
   $date = $yeartocheck."-".$monthtocheck."-".$daytocheck;

   //Set this to FALSE until proven otherwise.
   $weekendDay = false;

   //Get the day that this particular date falls on.
   $day = date("D", strtotime($date));

   //Check to see if it is equal to Sat or Sun.
   if($day == 'Sat' || $day == 'Sun'){
       //Set our $weekendDay variable to TRUE.
       $weekendDay = true;
   }

   //Output for testing purposes.
   if($weekendDay){
       return 'weekend';
   } else{
       return 'weekday';
   }
}

// ----------------------------------------------------------------------------------- //
// This function will check if the given date is a weekend or weekday, and return
// the result. It is used in the Trade Journal table.
// ----------------------------------------------------------------------------------- //
function check_today($daytocheck,$monthtocheck,$yeartocheck){

    //Date in YYYY-MM-DD format.
    $date = date($yeartocheck."-".$monthtocheck."-".$daytocheck);
 
    //Set this to FALSE until proven otherwise.
    $weekendDay = false;
    $today = false;
 
    //Get the day that this particular date falls on.
    $day = date("D", strtotime($date));
 
    //Check to see if it is equal to Sat or Sun.
    if($day == 'Sat' || $day == 'Sun'){
        //Set our $weekendDay variable to TRUE.
        $weekendDay = true;
    }elseif($date == date('Y-n-d')){
        $today = true;
    }
 
    //Output for testing purposes.
    if($today){
        return 'today';
    } else{
        return 'not today';
    }
 }

// ----------------------------------------------------------------------------------- //
// Creates a dropdown list. I have created this function because it was easier for me
// to set the correct ID in the values.
// ----------------------------------------------------------------------------------- //
function CreateDropDown($dropdown_values,$default){
  $selected = $default;

  foreach($dropdown_values as $val) {
      echo "<option value=\"" . $val . "\"" . ($val == $selected ? " selected=\"selected\">" : ">") . $val . "</option>";
  }
  return $val;
}

?>