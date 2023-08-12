<?php
declare(strict_types=1);
require('AttendanceProcessor.php');

use PHPUnit\Framework\TestCase;

final class AttendanceProcessorTest extends TestCase{

    public function testValidInput(): void
    {
        $items = ['Lecture', 'Lab', 'Support', 'Canvas'];
        $attendances = [2, 1, 2, 2];
        $total_hours = [33, 22, 44, 55];

        $processor = new AttendanceProcessor();
        $output = $processor->process($items, $attendances, $total_hours);

        $this->assertFalse($output['error']);
        $this->assertEquals($items, $output['items']);
        $this->assertEquals($attendances, $output['attendance']);
        // Add more assertions as needed
    }

    public function testEmptyItemName(): void
    {
        $items = ['Lecture', '', 'Support', 'Canvas']; // One item is empty
        $attendances = [2, 1, 2, 2];
        $total_hours = [33, 22, 44, 55];

        $processor = new AttendanceProcessor();
        $output = $processor->process($items, $attendances, $total_hours);

        $this->assertTrue($output['error']);
        $this->assertEquals("Item names cannot be empty.", $output['message']);
    }

    public function testAttendanceNotAnInteger(): void
    {
        $items = ['Lecture', 'Lab', 'Support', 'Canvas'];
        $attendances = [2, 'non-integer', 2, 2]; // One attendance is not an integer
        $total_hours = [33, 22, 44, 55];

        $processor = new AttendanceProcessor();
        $output = $processor->process($items, $attendances, $total_hours);

        $this->assertTrue($output['error']);
        $this->assertEquals("Attendance hours must be integers.", $output['message']);
    }

    public function testTotalHoursNotAnInteger(): void
    {
        $items = ['Lecture', 'Lab', 'Support', 'Canvas'];
        $attendances = [2, 1, 2, 2];
        $total_hours = [33, 2, 44, 55]; // One total_hours is not an integer

        $processor = new AttendanceProcessor();
        $output = $processor->process($items, $attendances, $total_hours);

        $this->assertTrue($output['error']);
        $this->assertEquals("Total hours must be integers.", $output['message']);
    }

    public function testAttendanceExceedsTotalHours(): void
    {
        $items = ['Lecture', 'Lab', 'Support', 'Canvas'];
        $attendances = [2, 50, 2, 2]; // One attendance is greater than total hours
        $total_hours = [33, 22, 44, 55];

        $processor = new AttendanceProcessor();
        $output = $processor->process($items, $attendances, $total_hours);

        $this->assertTrue($output['error']);
        $this->assertEquals("Attendance hours cannot exceed total assigned hours.", $output['message']);
    }

    public function testNegativeAttendance(): void
    {
        $items = ['Lecture', 'Lab', 'Support', 'Canvas'];
        $attendances = [2, -1, 2, 2]; // One attendance is negative
        $total_hours = [33, 22, 44, 55];

        $processor = new AttendanceProcessor();
        $output = $processor->process($items, $attendances, $total_hours);

        $this->assertTrue($output['error']);
        $this->assertEquals("Attendance hours cannot be negative.", $output['message']);
    }

    public function testNegativeTotalHours(): void
    {
        $items = ['Lecture', 'Lab', 'Support', 'Canvas'];
        $attendances = [2, 1, 2, 2];
        $total_hours = [33, -22, 44, 55]; // One total_hours is negative

        $processor = new AttendanceProcessor();
        $output = $processor->process($items, $attendances, $total_hours);

        $this->assertTrue($output['error']);
        $this->assertEquals("Total hours cannot be negative.", $output['message']);
    }

}