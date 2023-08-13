<?php
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");
require('functions.inc.php');

$item_1 = $_REQUEST['item_1'];
$item_2 = $_REQUEST['item_2'];
$item_3 = $_REQUEST['item_3'];
$item_4 = $_REQUEST['item_4'];
$attendance_1 = $_REQUEST['attendance_1'];
$attendance_2 = $_REQUEST['attendance_2'];
$attendance_3 = $_REQUEST['attendance_3'];
$attendance_4 = $_REQUEST['attendance_4'];
$total_hours_1 = $_REQUEST['total_hours_1'];
$total_hours_2 = $_REQUEST['total_hours_2'];
$total_hours_3 = $_REQUEST['total_hours_3'];
$total_hours_4 = $_REQUEST['total_hours_4'];

$items = array($item_1,$item_2,$item_3,$item_4);
$attendances = array($attendance_1,$attendance_2,$attendance_3,$attendance_4);
$total_hours = array($total_hours_1, $total_hours_2, $total_hours_3, $total_hours_4);

// First, call parameterChecker to validate the inputs
$parameter_check_output = parameterChecker($items, $attendances, $total_hours);

// If no error found, call getMaxMin and proceed
if (!$parameter_check_output['error']) {
    list($max_items, $min_items) = getMaxMin($items, $attendances);
    $output = array(
        "error" => false,
        "max_items" => $max_items,
        "min_items" => $min_items
    );
} else {
    // If there was an error in parameter checking, return the error information
    $output = $parameter_check_output;
}

// Send the output as a JSON response
echo json_encode($output);

exit();

?>
