<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\SewingLine;
use App\Models\Style;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MasterDataController extends Controller
{
    public function index(): View
    {
        $buyers = Buyer::withCount('styles')->orderBy('buyer_name')->get();
        $styles = Style::with('buyer')->orderBy('style_no')->get();
        $lines = SewingLine::orderBy('line_name')->get();

        return view('master.index', compact('buyers', 'styles', 'lines'));
    }

    public function getStylesByBuyer(int $buyerId): JsonResponse
    {
        $styles = Style::where('buyer_id', $buyerId)
            ->where('status', 'Active')
            ->orderBy('style_no')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $styles,
        ]);
    }

    public function storeBuyer(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'buyer_name'     => 'required|string|max:255|unique:buyers,buyer_name',
            'contact_person' => 'nullable|string|max:255',
            'email'          => 'nullable|email|max:255',
            'status'         => 'required|in:Active,Inactive',
        ]);

        $buyer = Buyer::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Buyer created successfully!',
            'data'    => $buyer,
        ], 201);
    }

    public function storeStyle(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'buyer_id'    => 'required|exists:buyers,id',
            'style_no'    => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'status'      => 'required|in:Active,Inactive',
        ]);

        $style = Style::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Style created successfully!',
            'data'    => $style->load('buyer'),
        ], 201);
    }

    public function storeLine(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'line_name' => 'required|string|max:100|unique:sewing_lines,line_name',
            'floor'     => 'nullable|string|max:50',
            'capacity'  => 'required|integer|min:1',
            'status'    => 'required|in:Active,Inactive',
        ]);

        $line = SewingLine::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Sewing Line created successfully!',
            'data'    => $line,
        ], 201);
    }
}
