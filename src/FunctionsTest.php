<?php
declare(strict_types=1);
require('functions.inc.php');
use PHPUnit\Framework\TestCase;

final class FunctionsTest extends TestCase{

    public function testGetMaxMinNormalCase()
    {
        $items = ['item1', 'item2', 'item3', 'item4'];
        $attendances = [10, 5, 10, 3];
        $result = getMaxMin($items, $attendances);

        $expectedMaxItems = ['item1 - 10', 'item3 - 10'];
        $expectedMinItems = ['item4 - 3'];

        $this->assertEquals($expectedMaxItems, $result[0]);
        $this->assertEquals($expectedMinItems, $result[1]);
    }

    # EMPTY INPUTS
    public function testGetMaxMinEmptyArrays()
    {
        $items = [];
        $attendances = [];
        $result = getMaxMin($items, $attendances);

        $this->assertEquals([], $result[0]);
        $this->assertEquals([], $result[1]);
    }

    # TESTING NEGATIVES 
    public function testGetMaxMinWithAllNegativeAttendances()
    {
        $items = ['item1', 'item2', 'item3'];
        $attendances = [-10, -20, -30];
        $result = getMaxMin($items, $attendances);

        $expectedMaxItems = ['item1 - -10'];
        $expectedMinItems = ['item3 - -30'];

        $this->assertEquals($expectedMaxItems, $result[0]);
        $this->assertEquals($expectedMinItems, $result[1]);
    }

    public function testGetMaxMinWithMixedNegativeAndPositiveAttendances()
    {
        $items = ['item1', 'item2', 'item3'];
        $attendances = [-10, 0, 10];
        $result = getMaxMin($items, $attendances);

        $expectedMaxItems = ['item3 - 10'];
        $expectedMinItems = ['item1 - -10'];

        $this->assertEquals($expectedMaxItems, $result[0]);
        $this->assertEquals($expectedMinItems, $result[1]);
    }

    # TESTING LARGE NUMBERS
    public function testGetMaxMinWithLargeNumbers()
    {
        $items = ['item1', 'item2'];
        $attendances = [PHP_INT_MAX, PHP_INT_MAX - 1];
        $result = getMaxMin($items, $attendances);

        $expectedMaxItems = ['item1 - ' . PHP_INT_MAX];
        $expectedMinItems = ['item2 - ' . (PHP_INT_MAX - 1)];

        $this->assertEquals($expectedMaxItems, $result[0]);
        $this->assertEquals($expectedMinItems, $result[1]);
    }

    public function testGetMaxMinWithLargeNegativeNumbers()
    {
        $items = ['item1', 'item2'];
        $attendances = [PHP_INT_MIN, PHP_INT_MIN + 1];
        $result = getMaxMin($items, $attendances);

        $expectedMaxItems = ['item2 - ' . (PHP_INT_MIN + 1)];
        $expectedMinItems = ['item1 - ' . PHP_INT_MIN];

        $this->assertEquals($expectedMaxItems, $result[0]);
        $this->assertEquals($expectedMinItems, $result[1]);
    }

    # Test Case with a Clear Maximum and Minimum
    public function testGetMaxMinWithClearMaxAndMin()
    {
        $items = ['item1', 'item2', 'item3'];
        $attendances = [5, 10, 3];
        $result = getMaxMin($items, $attendances);

        $expectedMaxItems = ['item2 - 10'];
        $expectedMinItems = ['item3 - 3'];

        $this->assertEquals($expectedMaxItems, $result[0]);
        $this->assertEquals($expectedMinItems, $result[1]);
    }

    # Test Case with Multiple Maximum and Minimum Values
    public function testGetMaxMinWithMultipleMaxAndMin()
    {
        $items = ['item1', 'item2', 'item3', 'item4'];
        $attendances = [10, 10, 5, 5];
        $result = getMaxMin($items, $attendances);

        $expectedMaxItems = ['item1 - 10', 'item2 - 10'];
        $expectedMinItems = ['item3 - 5', 'item4 - 5'];

        $this->assertEquals($expectedMaxItems, $result[0]);
        $this->assertEquals($expectedMinItems, $result[1]);
    }

    # Test Case with All Values Equal
    public function testGetMaxMinWithAllValuesEqual()
    {
        $items = ['item1', 'item2', 'item3'];
        $attendances = [5, 5, 5];
        $result = getMaxMin($items, $attendances);

        $expectedMaxItems = ['item1 - 5', 'item2 - 5', 'item3 - 5'];
        $expectedMinItems = ['item1 - 5', 'item2 - 5', 'item3 - 5'];

        $this->assertEquals($expectedMaxItems, $result[0]);
        $this->assertEquals($expectedMinItems, $result[1]);
    }

    # Test Case with Zero Values
    public function testGetMaxMinWithZeroValues()
    {
        $items = ['item1', 'item2'];
        $attendances = [0, 0];
        $result = getMaxMin($items, $attendances);

        $expectedMaxItems = ['item1 - 0', 'item2 - 0'];
        $expectedMinItems = ['item1 - 0', 'item2 - 0'];

        $this->assertEquals($expectedMaxItems, $result[0]);
        $this->assertEquals($expectedMinItems, $result[1]);
    }

    # Test Case with Single Item
    public function testGetMaxMinWithSingleItem()
    {
        $items = ['item1'];
        $attendances = [7];
        $result = getMaxMin($items, $attendances);

        $expectedMaxItems = ['item1 - 7'];
        $expectedMinItems = ['item1 - 7'];

        $this->assertEquals($expectedMaxItems, $result[0]);
        $this->assertEquals($expectedMinItems, $result[1]);
    }



    ## TESTING parameterChecker FUNCTION

    public function testValidInput(): void
    {
        $items = ['Lecture', 'Lab', 'Support', 'Canvas'];
        $attendances = [2, 1, 2, 2];
        $total_hours = [33, 22, 44, 55];

        // Call the parameterChecker function directly
        $output = parameterChecker($items, $attendances, $total_hours);

        // You can now assert the result without needing to decode JSON
        $this->assertFalse($output['error']);
        $this->assertEquals($items, $output['items']);
        $this->assertEquals($attendances, $output['attendance']);
        
    }

    public function testEmptyItemName(): void
    {
        $items = ['Lecture', '', 'Support', 'Canvas'];
        $attendances = [2, 1, 2, 2];
        $total_hours = [33, 22, 44, 55];

        $output = parameterChecker($items, $attendances, $total_hours);

        $this->assertTrue($output['error']);
        $this->assertEquals("Item names cannot be empty.", $output['message']);
    }

    public function testAttendanceNotAnInteger(): void
    {
        $items = ['Lecture', 'Lab', 'Support', 'Canvas'];
        $attendances = [2, 'non-integer', 2, 2];
        $total_hours = [33, 22, 44, 55];

        $output = parameterChecker($items, $attendances, $total_hours);

        $this->assertTrue($output['error']);
        $this->assertEquals("Attendance hours must be integers.", $output['message']);
    }

    public function testTotalHoursNotAnInteger(): void
    {
        $items = ['Lecture', 'Lab', 'Support', 'Canvas'];
        $attendances = [2, 1, 2, 2];
        $total_hours = [33, 'non-integer', 44, 55];

        $output = parameterChecker($items, $attendances, $total_hours);

        $this->assertTrue($output['error']);
        $this->assertEquals("Total hours must be integers.", $output['message']);
    }

    public function testAttendanceExceedsTotalHours(): void
    {
        $items = ['Lecture', 'Lab', 'Support', 'Canvas'];
        $attendances = [2, 50, 2, 2];
        $total_hours = [33, 22, 44, 55];

        $output = parameterChecker($items, $attendances, $total_hours);

        $this->assertTrue($output['error']);
        $this->assertEquals("Attendance hours cannot exceed total assigned hours.", $output['message']);
    }

    public function testNegativeAttendance(): void
    {
        $items = ['Lecture', 'Lab', 'Support', 'Canvas'];
        $attendances = [2, -1, 2, 2];
        $total_hours = [33, 22, 44, 55];

        $output = parameterChecker($items, $attendances, $total_hours);

        $this->assertTrue($output['error']);
        $this->assertEquals("Attendance hours cannot be negative.", $output['message']);
    }

    public function testNegativeTotalHours(): void
    {
        $items = ['Lecture', 'Lab', 'Support', 'Canvas'];
        $attendances = [2, 1, 2, 2];
        $total_hours = [33, -22, 44, 55];

        $output = parameterChecker($items, $attendances, $total_hours);

        $this->assertTrue($output['error']);
        $this->assertEquals("Total hours cannot be negative.", $output['message']);
    }

}