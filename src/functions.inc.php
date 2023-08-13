<?php

function getMaxMin($items, $attendances)
{
    // Check if the input arrays are empty
    if (empty($items) || empty($attendances)) {
        return array([], []);
    }
    
    $max_attendance = max($attendances);
    $min_attendance = min($attendances);
    $max_items = array();
    $min_items = array();

    for ($i = 0; $i < count($items); $i++) {
        if ($attendances[$i] == $max_attendance) {
            $max_items[] = $items[$i] . ' - ' . $attendances[$i];
        }
        if ($attendances[$i] == $min_attendance) {
            $min_items[] = $items[$i] . ' - ' . $attendances[$i];
        }
    }

    return array($max_items, $min_items);
}

function parameterChecker($items, $attendances, $total_hours)
{
  $output = array(
    "error" => false,
    "message" => "",
    "items" => $items,
    "attendance" => $attendances,
    "total_hours" => $total_hours
  );

  // Check if any session names are empty (as outlined in Section B of spec)
  foreach($items as $item) {
    if(empty($item)) {
      $output['error'] = true;
      $output['message'] = "Item names cannot be empty.";
      return $output;
      exit();
    }
  }

  for($i = 0; $i < count($attendances); $i++) {
    $attendance = $attendances[$i];
    $total_assigned_hours = $total_hours[$i]; // Get the corresponding total hours
    
    // Check if attendance is a number/numeric string OR a float instead of an int
    if(!is_numeric($attendance) || (int)$attendance != $attendance) {
      $output['error'] = true;
      $output['message'] = "Attendance hours must be integers.";
      return $output;
      exit();
    }

    // Check if total hours is a number/numeric string OR a float instead of an int (even though it's hard coded)
    if(!is_numeric($total_assigned_hours) || (int)$total_assigned_hours != $total_assigned_hours) {
      $output['error'] = true;
      $output['message'] = "Total hours must be integers.";
      return $output;
      exit();
    }

    // Check if attendance is non-negative
    if ($attendance < 0) {
      $output['error'] = true;
      $output['message'] = "Attendance hours cannot be negative.";
      return $output;
      exit();
    }

    // Check if total hours is non-negative
    if ($total_assigned_hours < 0) {
      $output['error'] = true;
      $output['message'] = "Total hours cannot be negative.";
      return $output;
      exit();
    }

    // Check if attendance is within acceptable range
    if($attendance > $total_assigned_hours) {
      $output['error'] = true;
      $output['message'] = "Attendance hours cannot exceed total assigned hours.";
      return $output;
      exit();
    }
  }

  return $output;

}

?>