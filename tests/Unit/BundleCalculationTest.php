<?php

namespace Tests\Unit;

use App\Models\ProductionBundle;
use PHPUnit\Framework\TestCase;

class BundleCalculationTest extends TestCase
{
    public function test_balance_quantity_calculation(): void
    {
        $bundle = new ProductionBundle([
            'quantity'      => 500,
            'completed_qty' => 300,
            'rejected_qty'  => 50,
        ]);

        $this->assertEquals(150, $bundle->balance_qty);
    }

    public function test_efficiency_percentage_calculation(): void
    {
        $bundle = new ProductionBundle([
            'quantity'      => 500,
            'completed_qty' => 480,
            'rejected_qty'  => 15,
        ]);

        $this->assertEquals(96.0, $bundle->efficiency_percentage);
    }

    public function test_rejection_percentage_calculation(): void
    {
        $bundle = new ProductionBundle([
            'quantity'      => 500,
            'completed_qty' => 480,
            'rejected_qty'  => 15,
        ]);

        $this->assertEquals(3.0, $bundle->rejection_percentage);
    }

    public function test_zero_quantity_does_not_cause_division_by_zero(): void
    {
        $bundle = new ProductionBundle([
            'quantity'      => 0,
            'completed_qty' => 0,
            'rejected_qty'  => 0,
        ]);

        $this->assertEquals(0, $bundle->balance_qty);
        $this->assertEquals(0.0, $bundle->efficiency_percentage);
        $this->assertEquals(0.0, $bundle->rejection_percentage);
    }

    public function test_status_label_determination(): void
    {
        // 1. Pending: no completed or rejected
        $pending = new ProductionBundle(['quantity' => 100, 'completed_qty' => 0, 'rejected_qty' => 0]);
        $this->assertEquals('PENDING', $pending->status_label);

        // 2. In Progress: partially completed
        $inProgress = new ProductionBundle(['quantity' => 100, 'completed_qty' => 40, 'rejected_qty' => 5]);
        $this->assertEquals('IN PROGRESS', $inProgress->status_label);

        // 3. Passed: 100% completed with minimal rejects
        $passed = new ProductionBundle(['quantity' => 100, 'completed_qty' => 95, 'rejected_qty' => 5]);
        $this->assertEquals('PASSED', $passed->status_label);

        // 4. Rejected: majority rejected
        $rejected = new ProductionBundle(['quantity' => 100, 'completed_qty' => 20, 'rejected_qty' => 80]);
        $this->assertEquals('REJECTED', $rejected->status_label);
    }
}