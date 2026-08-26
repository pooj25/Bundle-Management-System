<?php

namespace App\Console\Commands;

use App\Models\Buyer;
use App\Models\SewingLine;
use App\Models\Style;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Generate50kBundles extends Command
{
    protected $signature = 'bundle:generate-50k {count=50000 : Number of bundle records to generate}';
    protected $description = 'Quickly generate high-volume production bundles (50,000+) using chunked batch insertion to benchmark indexing and performance';

    public function handle(): int
    {
        $count = (int)$this->argument('count');
        $this->info("Starting high-performance generation of {$count} production bundles...");

        $buyerIds = Buyer::pluck('id')->toArray();
        if (empty($buyerIds)) {
            $this->error('Please run php artisan db:seed first to generate master data.');
            return 1;
        }

        $lineIds = SewingLine::pluck('id')->toArray();
        $buyerStyles = [];
        foreach ($buyerIds as $bId) {
            $buyerStyles[$bId] = Style::where('buyer_id', $bId)->pluck('id')->toArray();
        }

        $colors = ['Navy', 'Black', 'White', 'Olive', 'Charcoal', 'Royal Blue', 'Heather Grey', 'Sky Blue', 'Burgundy', 'Khaki', 'Coral', 'Teal'];
        $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '28/30', '30/32', '32/32', '34/32', '36/32'];
        $operators = ['John Miller', 'Robert Chen', 'Maria Gomez', 'Alex Turner', 'Elena Fisher', 'Sam Wilson', 'Lucas Vance', 'Sophia Taylor', 'Liam Nelson', 'Amina Khan', 'David Zhang', 'Claire Dubois'];

        $chunkSize = 2500;
        $chunks = ceil($count / $chunkSize);
        $totalInserted = 0;
        $startTime = microtime(true);
        $lastIdQuery = DB::table('production_bundles')->max('id') ?? 0;
        $baseBundleNum = 100000 + $lastIdQuery;

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        for ($c = 0; $c < $chunks; $c++) {
            $currentChunkCount = min($chunkSize, $count - $totalInserted);
            $batch = [];

            for ($i = 0; $i < $currentChunkCount; $i++) {
                $seq = $baseBundleNum + $totalInserted + $i + 1;
                $buyerId = $buyerIds[array_rand($buyerIds)];
                $styles = $buyerStyles[$buyerId] ?? [];
                $styleId = !empty($styles) ? $styles[array_rand($styles)] : 1;
                $lineId = $lineIds[array_rand($lineIds)];
                $color = $colors[array_rand($colors)];
                $size = $sizes[array_rand($sizes)];
                $operator = $operators[array_rand($operators)];

                $qty = rand(25, 1000);
                $compRatio = rand(30, 100) / 100;
                $completed = (int)round($qty * $compRatio);
                $remaining = max(0, $qty - $completed);
                $rejected = rand(0, min(15, $remaining));

                $daysAgo = rand(0, 90);
                $prodDate = Carbon::today()->subDays($daysAgo)->toDateString();
                $now = Carbon::now()->subDays($daysAgo)->toDateTimeString();

                $batch[] = [
                    'bundle_no'       => 'BN-PERF-' . $seq,
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
                    'remarks'         => 'Benchmark dataset record',
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];
            }

            DB::table('production_bundles')->insert($batch);
            $totalInserted += $currentChunkCount;
            $bar->advance($currentChunkCount);
        }

        $bar->finish();
        $this->newLine();

        $elapsed = round(microtime(true) - $startTime, 2);
        $this->info("Successfully generated {$totalInserted} bundle records in {$elapsed} seconds!");
        return 0;
    }
}
