<?php
class AttendanceProcessor
{
    public function process($items, $attendances, $total_hours)
    {
        $output = array(
            "error" => false,
            "message" => "",
            "items" => "",
            "attendance" => 0,
            "max_items" => "",
            "min_items" => ""
        );

        // Check if any session names are empty (as outlined in Section B of spec)
        foreach($items as $item) {
            if(empty($item)) {
                $output['error'] = true;
                $output['message'] = "Item names cannot be empty.";
                return json_encode($output);
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
            return json_encode($output);
            exit();
            }

            // Check if total hours is a number/numeric string OR a float instead of an int (even though it's hard coded)
            if(!is_numeric($total_assigned_hours) || (int)$total_assigned_hours != $total_assigned_hours) {
                $output['error'] = true;
                $output['message'] = "Total hours must be integers.";
                return json_encode($output);
                exit();
            }

            // Check if attendance is non-negative
            if ($attendance < 0) {
                $output['error'] = true;
                $output['message'] = "Attendance hours cannot be negative.";
                return json_encode($output);
                exit();
            }

            // Check if total hours is non-negative
            if ($total_assigned_hours < 0) {
                $output['error'] = true;
                $output['message'] = "Total hours cannot be negative.";
                return json_encode($output);
                exit();
            }

            // Check if attendance is within acceptable range
            if($attendance > $total_assigned_hours) {
                $output['error'] = true;
                $output['message'] = "Attendance hours cannot exceed total assigned hours.";
                return json_encode($output);
                exit();
            }
        }

        $max_min_items=getMaxMin($items, $attendances);

        $output['items']=$items;
        $output['attendance']=$attendances;
        $output['max_items']=$max_min_items[0];
        $output['min_items']=$max_min_items[1];

        return $output;

    }
}
?>