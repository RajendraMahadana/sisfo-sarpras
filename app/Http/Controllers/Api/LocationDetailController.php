<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\LocationDetail;
use App\Http\Controllers\Controller;

class LocationDetailController extends Controller
{
    public function index(Request $request)
    {
        $locationId = $request->query('location_id');

        // Ambil detail lokasi berdasarkan location_id
        $details = LocationDetail::where('location_id', $locationId)->get();

        // Format data untuk dikirim sebagai JSON
        return response()->json($details);
    }
}
