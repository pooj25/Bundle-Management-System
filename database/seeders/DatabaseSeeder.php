<?php

namespace Database\Seeders;

use App\Models\Buyer;
use App\Models\ProductionBundle;
use App\Models\SewingLine;
use App\Models\Style;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Buyers
        $buyersData = [
            ['buyer_name' => 'Global Retail', 'contact_person' => 'John Doe', 'email' => 'john@global.com', 'status' => 'Active'],
            ['buyer_name' => 'Urban Out', 'contact_person' => 'Sarah Smith', 'email' => 'sarah@urban.com', 'status' => 'Active'],
            ['buyer_name' => 'Metro Wear', 'contact_person' => 'Mike Ross', 'email' => 'mike@metro.com', 'status' => 'Active'],
            ['buyer_name' => 'Apex Apparel', 'contact_person' => 'Emma Watson', 'email' => 'emma@apex.com', 'status' => 'Active'],
            ['buyer_name' => 'Zara Tex', 'contact_person' => 'David Lee', 'email' => 'david@zaratex.com', 'status' => 'Active'],
            ['buyer_name' => 'Nordic Fashion', 'contact_person' => 'Elena Rostova', 'email' => 'elena@nordic.com', 'status' => 'Inactive'],
        ];

        $buyerModels = [];
        foreach ($buyersData as $data) {
            $buyerModels[$data['buyer_name']] = Buyer::create($data);
        }

        // 2. Seed Styles
        $stylesData = [
            ['buyer' => 'Global Retail', 'style_no' => 'ST-8821', 'description' => 'Men Regular Chino Pants'],
            ['buyer' => 'Global Retail', 'style_no' => 'ST-402 / PO-992', 'description' => 'Cotton Polo T-Shirt'],
            ['buyer' => 'Urban Out', 'style_no' => 'UO-22X', 'description' => 'Denim Slim Fit Jeans'],
            ['buyer' => 'Urban Out', 'style_no' => 'ST-118 / PO-881', 'description' => 'Hooded Sweatshirt Olive'],
            ['buyer' => 'Metro Wear', 'style_no' => 'ST-209 / PO-774', 'description' => 'Linen Formal Shirt'],
            ['buyer' => 'Metro Wear', 'style_no' => 'MW-554', 'description' => 'Cargo Short Khaki'],
            ['buyer' => 'Apex Apparel', 'style_no' => 'AP-901', 'description' => 'Women Knit Top'],
            ['buyer' => 'Zara Tex', 'style_no' => 'ZT-300', 'description' => 'Bomber Jacket Black'],
        ];

        $styleModels = [];
        foreach ($stylesData as $data) {
            $buyer = $buyerModels[$data['buyer']];
            $style = Style::create([
                'buyer_id'    => $buyer->id,
                'style_no'    => $data['style_no'],
                'description' => $data['description'],
                'status'      => 'Active',
            ]);
            $styleModels[$data['style_no']] = $style;
        }

        // 3. Seed Sewing Lines
        $linesData = [
            ['line_name' => 'A1', 'floor' => 'Floor 1', 'capacity' => 1200, 'status' => 'Active'],
            ['line_name' => 'A2', 'floor' => 'Floor 1', 'capacity' => 1000, 'status' => 'Active'],
            ['line_name' => 'B1', 'floor' => 'Floor 2', 'capacity' => 800, 'status' => 'Active'],
            ['line_name' => 'B2', 'floor' => 'Floor 2', 'capacity' => 950, 'status' => 'Active'],
            ['line_name' => 'C1', 'floor' => 'Floor 3', 'capacity' => 1100, 'status' => 'Active'],
            ['line_name' => 'C2', 'floor' => 'Floor 3', 'capacity' => 900, 'status' => 'Active'],
        ];

        $lineModels = [];
        foreach ($linesData as $data) {
            $lineModels[$data['line_name']] = SewingLine::create($data);
        }

        // 4. Seed Reference Bundles matching Mockup Screenshots
        $screenshotBundles = [
            [
                'bundle_no'       => 'BN-1042',
                'buyer_id'        => $buyerModels['Global Retail']->id,
                'style_id'        => $styleModels['ST-8821']->id,
                'line_id'         => $lineModels['A1']->id,
                'color'           => 'Navy',
                'size'            => 'M',
                'quantity'        => 500,
                'completed_qty'   => 480,
                'rejected_qty'    => 15,
                'operator_name'   => 'John Miller',
                'production_date' => Carbon::today()->toDateString(),
                'remarks'         => 'High efficiency lot',
                'created_at'      => Carbon::now()->subMinutes(10),
                'updated_at'      => Carbon::now()->subMinutes(10),
            ],
            [
                'bundle_no'       => 'BN-1043',
                'buyer_id'        => $buyerModels['Global Retail']->id,
                'style_id'        => $styleModels['ST-8821']->id,
                'line_id'         => $lineModels['A1']->id,
                'color'           => 'Navy',
                'size'            => 'L',
                'quantity'        => 600,
                'completed_qty'   => 590,
                'rejected_qty'    => 8,
                'operator_name'   => 'Robert Chen',
                'production_date' => Carbon::today()->toDateString(),
                'remarks'         => 'Excellent quality, minimal defects',
                'created_at'      => Carbon::now()->subMinutes(25),
                'updated_at'      => Carbon::now()->subMinutes(25),
            ],
            [
                'bundle_no'       => 'BN-1044',
                'buyer_id'        => $buyerModels['Urban Out']->id,
                'style_id'        => $styleModels['UO-22X']->id,
                'line_id'         => $lineModels['B2']->id,
                'color'           => 'Olive',
                'size'            => 'S',
                'quantity'        => 350,
                'completed_qty'   => 200,
                'rejected_qty'    => 25,
                'operator_name'   => 'Maria Gomez',
                'production_date' => Carbon::today()->toDateString(),
                'remarks'         => 'Thread tension adjusted mid-batch',
                'created_at'      => Carbon::now()->subMinutes(40),
                'updated_at'      => Carbon::now()->subMinutes(40),
            ],
            [
                'bundle_no'       => 'BN-29384',
                'buyer_id'        => $buyerModels['Global Retail']->id,
                'style_id'        => $styleModels['ST-402 / PO-992']->id,
                'line_id'         => $lineModels['A2']->id,
                'color'           => 'White',
                'size'            => 'L',
                'quantity'        => 120,
                'completed_qty'   => 70,
                'rejected_qty'    => 2,
                'operator_name'   => 'Alex Turner',
                'production_date' => Carbon::today()->toDateString(),
                'remarks'         => 'In cutting-sewing transition',
                'created_at'      => Carbon::now()->subMinutes(5),
                'updated_at'      => Carbon::now()->subMinutes(5),
            ],
            [
                'bundle_no'       => 'BN-29383',
                'buyer_id'        => $buyerModels['Global Retail']->id,
                'style_id'        => $styleModels['ST-402 / PO-992']->id,
                'line_id'         => $lineModels['A2']->id,
                'color'           => 'Black',
                'size'            => 'M',
                'quantity'        => 120,
                'completed_qty'   => 0,
                'rejected_qty'    => 0,
                'operator_name'   => 'Elena Fisher',
                'production_date' => Carbon::today()->toDateString(),
                'remarks'         => 'Pending line setup',
                'created_at'      => Carbon::now()->subMinutes(45),
                'updated_at'      => Carbon::now()->subMinutes(45),
            ],
            [
                'bundle_no'       => 'BN-29380',
                'buyer_id'        => $buyerModels['Urban Out']->id,
                'style_id'        => $styleModels['ST-118 / PO-881']->id,
                'line_id'         => $lineModels['B1']->id,
                'color'           => 'Heather Grey',
                'size'            => 'XL',
                'quantity'        => 85,
                'completed_qty'   => 85,
                'rejected_qty'    => 0,
                'operator_name'   => 'Sam Wilson',
                'production_date' => Carbon::yesterday()->toDateString(),
                'remarks'         => 'Passed 100% QC inspection',
                'created_at'      => Carbon::now()->subHours(2),
                'updated_at'      => Carbon::now()->subHours(2),
            ],
            [
                'bundle_no'       => 'BN-29375',
                'buyer_id'        => $buyerModels['Metro Wear']->id,
                'style_id'        => $styleModels['ST-209 / PO-774']->id,
                'line_id'         => $lineModels['C1']->id,
                'color'           => 'Sky Blue',
                'size'            => 'M',
                'quantity'        => 40,
                'completed_qty'   => 10,
                'rejected_qty'    => 30,
                'operator_name'   => 'Lucas Vance',
                'production_date' => Carbon::yesterday()->toDateString(),
                'remarks'         => 'Fabric flaw rejected by QC',
                'created_at'      => Carbon::now()->subHours(3),
                'updated_at'      => Carbon::now()->subHours(3),
            ],
        ];

        DB::table('production_bundles')->insert($screenshotBundles);

        // 5. Generate additional realistic batches (150 total records for smooth immediate demo)
        $colors = ['Navy', 'Black', 'White', 'Olive', 'Charcoal', 'Royal Blue', 'Heather Grey', 'Sky Blue', 'Burgundy', 'Khaki'];
        $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL', '30/32', '32/32', '34/32', '36/32'];
        $operators = ['John Miller', 'Robert Chen', 'Maria Gomez', 'Alex Turner', 'Elena Fisher', 'Sam Wilson', 'Lucas Vance', 'Sophia Taylor', 'Liam Nelson', 'Amina Khan'];

        $allBuyerIds = Buyer::pluck('id')->toArray();
        $buyerStyles = [];
        foreach ($allBuyerIds as $bId) {
            $buyerStyles[$bId] = Style::where('buyer_id', $bId)->pluck('id')->toArray();
        }
        $allLineIds = SewingLine::pluck('id')->toArray();

        $batch = [];
        for ($i = 1; $i <= 150; $i++) {
            $buyerId = $allBuyerIds[array_rand($allBuyerIds)];
            $availableStyles = $buyerStyles[$buyerId] ?? [];
            if (empty($availableStyles)) {
                continue;
            }
            $styleId = $availableStyles[array_rand($availableStyles)];
            $lineId = $allLineIds[array_rand($allLineIds)];
            $color = $colors[array_rand($colors)];
            $size = $sizes[array_rand($sizes)];
            $operator = $operators[array_rand($operators)];

            $qty = rand(20, 500);
            $daysAgo = rand(0, 14);
            $prodDate = Carbon::today()->subDays($daysAgo)->toDateString();

            // Realistic completion and rejection rates
            $compRatio = rand(40, 100) / 100;
            $completed = (int)round($qty * $compRatio);
            $maxRej = max(0, $qty - $completed);
            $rejected = rand(0, min(10, $maxRej));

            $batch[] = [
                'bundle_no'       => 'BN-' . (30000 + $i),
                'buyer_id'        => $buyerId,
                'style_id'        => $styleId,
                'line_id'         => $lineId,
                'color'           => $color,
                'size'            => $size,
                'quantity'        => $qty,
                'completed_qty'   => $completed,
                'rejected_qty'    => $rejected,
                'operator_name'   => $operator,
                'production_date' => $prodDate,
                'remarks'         => rand(0, 1) ? 'Standard production run' : null,
                'created_at'      => Carbon::now()->subDays($daysAgo)->subHours(rand(1, 8)),
                'updated_at'      => Carbon::now()->subDays($daysAgo)->subHours(rand(1, 8)),
            ];
        }

        DB::table('production_bundles')->insert($batch);
    }
}
