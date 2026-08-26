<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\ProductionBundle;
use App\Models\SewingLine;
use App\Models\Style;
use Carbon\Carbon;
use Illuminate\View\View;

class ErpModulesController extends Controller
{
    public function sourcing(): View
    {
        $buyers = Buyer::where('status', 'Active')->get();
        return view('modules.sourcing', compact('buyers'));
    }

    public function cutting(): View
    {
        $buyers = Buyer::where('status', 'Active')->get();
        $styles = Style::where('status', 'Active')->get();
        return view('modules.cutting', compact('buyers', 'styles'));
    }

    public function qc(): View
    {
        $recentInspections = ProductionBundle::with(['buyer', 'style', 'sewingLine'])
            ->where('completed_qty', '>', 0)
            ->latest('updated_at')
            ->limit(20)
            ->get();

        return view('modules.qc', compact('recentInspections'));
    }

    public function shipping(): View
    {
        $readyShipments = ProductionBundle::with(['buyer', 'style', 'sewingLine'])
            ->whereColumn('completed_qty', '>=', 'quantity')
            ->latest('updated_at')
            ->limit(20)
            ->get();

        return view('modules.shipping', compact('readyShipments'));
    }

    public function settings(): View
    {
        return view('modules.settings');
    }

    public function support(): View
    {
        return view('modules.support');
    }
}
