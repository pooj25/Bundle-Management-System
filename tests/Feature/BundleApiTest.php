<?php

namespace Tests\Feature;

use App\Models\Buyer;
use App\Models\ProductionBundle;
use App\Models\SewingLine;
use App\Models\Style;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BundleApiTest extends TestCase
{
    use RefreshDatabase;

    protected $buyer;
    protected $style;
    protected $line;

    protected function setUp(): void
    {
        parent::setUp();

        $this->buyer = Buyer::create(['buyer_name' => 'Global Brand', 'status' => 'Active']);
        $this->style = Style::create(['buyer_id' => $this->buyer->id, 'style_no' => 'GB-100', 'status' => 'Active']);
        $this->line = SewingLine::create(['line_name' => 'L-Alpha', 'capacity' => 1200, 'status' => 'Active']);
    }

    public function test_can_create_bundle_via_api(): void
    {
        $payload = [
            'bundle_no'       => 'BN-API-100',
            'buyer_id'        => $this->buyer->id,
            'style_id'        => $this->style->id,
            'line_id'         => $this->line->id,
            'color'           => 'Black',
            'size'            => 'L',
            'quantity'        => 300,
            'completed_qty'   => 280,
            'rejected_qty'    => 10,
            'operator_name'   => 'John Tester',
            'production_date' => Carbon::today()->toDateString(),
            'remarks'         => 'API creation test',
        ];

        $response = $this->postJson('/api/bundles', $payload);

        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'data' => [
                'bundle_no' => 'BN-API-100',
                'quantity'  => 300,
                'completed_qty' => 280,
                'rejected_qty'  => 10,
            ],
        ]);

        $this->assertDatabaseHas('production_bundles', [
            'bundle_no' => 'BN-API-100',
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'CREATED',
        ]);
    }

    public function test_can_list_and_search_bundles_via_api(): void
    {
        ProductionBundle::create([
            'bundle_no'       => 'BN-SEARCH-ALPHA',
            'buyer_id'        => $this->buyer->id,
            'style_id'        => $this->style->id,
            'line_id'         => $this->line->id,
            'color'           => 'Red',
            'size'            => 'XL',
            'quantity'        => 200,
            'completed_qty'   => 150,
            'rejected_qty'    => 5,
            'production_date' => Carbon::today()->toDateString(),
        ]);

        ProductionBundle::create([
            'bundle_no'       => 'BN-SEARCH-BETA',
            'buyer_id'        => $this->buyer->id,
            'style_id'        => $this->style->id,
            'line_id'         => $this->line->id,
            'color'           => 'Blue',
            'size'            => 'S',
            'quantity'        => 100,
            'completed_qty'   => 80,
            'rejected_qty'    => 2,
            'production_date' => Carbon::today()->toDateString(),
        ]);

        $response = $this->getJson('/api/bundles?search=ALPHA');
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.bundle_no', 'BN-SEARCH-ALPHA');
    }

    public function test_can_get_single_bundle_via_api(): void
    {
        $bundle = ProductionBundle::create([
            'bundle_no'       => 'BN-GET-ONE',
            'buyer_id'        => $this->buyer->id,
            'style_id'        => $this->style->id,
            'line_id'         => $this->line->id,
            'color'           => 'White',
            'size'            => 'M',
            'quantity'        => 150,
            'completed_qty'   => 100,
            'rejected_qty'    => 10,
            'production_date' => Carbon::today()->toDateString(),
        ]);

        $response = $this->getJson("/api/bundles/{$bundle->id}");
        $response->assertStatus(200);
        $response->assertJsonPath('data.bundle_no', 'BN-GET-ONE');
        $response->assertJsonPath('data.balance_qty', 40);
    }

    public function test_can_update_bundle_via_api(): void
    {
        $bundle = ProductionBundle::create([
            'bundle_no'       => 'BN-UPDATE-TEST',
            'buyer_id'        => $this->buyer->id,
            'style_id'        => $this->style->id,
            'line_id'         => $this->line->id,
            'color'           => 'Green',
            'size'            => 'S',
            'quantity'        => 100,
            'completed_qty'   => 50,
            'rejected_qty'    => 0,
            'production_date' => Carbon::today()->toDateString(),
        ]);

        $updatePayload = [
            'bundle_no'       => 'BN-UPDATE-TEST',
            'buyer_id'        => $this->buyer->id,
            'style_id'        => $this->style->id,
            'line_id'         => $this->line->id,
            'color'           => 'Green',
            'size'            => 'S',
            'quantity'        => 100,
            'completed_qty'   => 90,
            'rejected_qty'    => 5,
            'production_date' => Carbon::today()->toDateString(),
        ];

        $response = $this->putJson("/api/bundles/{$bundle->id}", $updatePayload);
        $response->assertStatus(200);
        $response->assertJsonPath('data.completed_qty', 90);
        $response->assertJsonPath('data.rejected_qty', 5);
        $response->assertJsonPath('data.balance_qty', 5);
    }

    public function test_can_soft_delete_bundle_via_api(): void
    {
        $bundle = ProductionBundle::create([
            'bundle_no'       => 'BN-DELETE-TEST',
            'buyer_id'        => $this->buyer->id,
            'style_id'        => $this->style->id,
            'line_id'         => $this->line->id,
            'color'           => 'Khaki',
            'size'            => '32/32',
            'quantity'        => 100,
            'completed_qty'   => 100,
            'rejected_qty'    => 0,
            'production_date' => Carbon::today()->toDateString(),
        ]);

        $response = $this->deleteJson("/api/bundles/{$bundle->id}");
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertSoftDeleted('production_bundles', ['id' => $bundle->id]);
    }

    public function test_dashboard_api_returns_aggregated_metrics(): void
    {
        ProductionBundle::create([
            'bundle_no'       => 'BN-DASH-1',
            'buyer_id'        => $this->buyer->id,
            'style_id'        => $this->style->id,
            'line_id'         => $this->line->id,
            'color'           => 'Navy',
            'size'            => 'M',
            'quantity'        => 500,
            'completed_qty'   => 450,
            'rejected_qty'    => 20,
            'production_date' => Carbon::today()->toDateString(),
        ]);

        $response = $this->getJson('/api/dashboard');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'total_bundles',
                'total_quantity',
                'total_completed',
                'total_rejected',
                'completion_rate',
                'defect_rate',
                'avg_efficiency',
                'today_production',
                'today_rejection',
                'chart' => ['labels', 'produced', 'rejected'],
                'recent_bundles',
            ],
        ]);
    }
}