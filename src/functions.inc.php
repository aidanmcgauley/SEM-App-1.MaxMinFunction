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

?>