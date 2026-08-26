<?php

namespace Tests\Feature;

use App\Models\Buyer;
use App\Models\SewingLine;
use App\Models\Style;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BundleValidationRulesTest extends TestCase
{
    use RefreshDatabase;

    protected $buyer;
    protected $style;
    protected $line;

    protected function setUp(): void
    {
        parent::setUp();

        $this->buyer = Buyer::create(['buyer_name' => 'Test Buyer', 'status' => 'Active']);
        $this->style = Style::create(['buyer_id' => $this->buyer->id, 'style_no' => 'ST-TEST', 'status' => 'Active']);
        $this->line = SewingLine::create(['line_name' => 'L1', 'capacity' => 1000, 'status' => 'Active']);
    }

    public function test_bundle_creation_requires_mandatory_fields(): void
    {
        $response = $this->postJson('/bundles', []);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['bundle_no', 'buyer_id', 'style_id', 'line_id', 'color', 'size', 'quantity', 'production_date']);
    }

    public function test_bundle_number_must_be_unique(): void
    {
        $payload = [
            'bundle_no'       => 'BN-UNIQUE-001',
            'buyer_id'        => $this->buyer->id,
            'style_id'        => $this->style->id,
            'line_id'         => $this->line->id,
            'color'           => 'Navy',
            'size'            => 'M',
            'quantity'        => 100,
            'completed_qty'   => 50,
            'rejected_qty'    => 5,
            'production_date' => Carbon::today()->toDateString(),
        ];

        $first = $this->postJson('/bundles', $payload);
        $first->assertStatus(201);

        $second = $this->postJson('/bundles', $payload);
        $second->assertStatus(422);
        $second->assertJsonValidationErrors(['bundle_no']);
    }

    public function test_quantity_must_be_greater_than_zero(): void
    {
        $payload = [
            'bundle_no'       => 'BN-QTY-ZERO',
            'buyer_id'        => $this->buyer->id,
            'style_id'        => $this->style->id,
            'line_id'         => $this->line->id,
            'color'           => 'Navy',
            'size'            => 'M',
            'quantity'        => 0,
            'completed_qty'   => 0,
            'rejected_qty'    => 0,
            'production_date' => Carbon::today()->toDateString(),
        ];

        $response = $this->postJson('/bundles', $payload);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['quantity']);
    }

    public function test_completed_plus_rejected_cannot_exceed_total_quantity(): void
    {
        $payload = [
            'bundle_no'       => 'BN-MATH-ERROR',
            'buyer_id'        => $this->buyer->id,
            'style_id'        => $this->style->id,
            'line_id'         => $this->line->id,
            'color'           => 'Navy',
            'size'            => 'M',
            'quantity'        => 100,
            'completed_qty'   => 80,
            'rejected_qty'    => 30, // 80 + 30 = 110 > 100
            'production_date' => Carbon::today()->toDateString(),
        ];

        $response = $this->postJson('/bundles', $payload);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['completed_qty']);
    }

    public function test_production_date_cannot_be_in_the_future(): void
    {
        $payload = [
            'bundle_no'       => 'BN-FUTURE-DATE',
            'buyer_id'        => $this->buyer->id,
            'style_id'        => $this->style->id,
            'line_id'         => $this->line->id,
            'color'           => 'Navy',
            'size'            => 'M',
            'quantity'        => 100,
            'completed_qty'   => 10,
            'rejected_qty'    => 0,
            'production_date' => Carbon::tomorrow()->toDateString(),
        ];

        $response = $this->postJson('/bundles', $payload);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['production_date']);
    }
}