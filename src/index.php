<?php
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");
require('functions.inc.php');
require('AttendanceProcessor.php');

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

$processor = new AttendanceProcessor();
$output = $processor->process($items, $attendances, $total_hours);

echo json_encode($output);
exit();
