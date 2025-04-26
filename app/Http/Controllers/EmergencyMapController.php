<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Events\EmergencyCalled;
use App\Facades\Geo;

class EmergencyMapController extends Controller
{
   public function index() {
    return Inertia::render('EmergencyMap', [
        'emergencyMap' => [
            'title' => 'Emergency Map',
            'description' => 'This is the emergency map page.',
        ],
    ]);
   }

   public function store(Request $request) {
    // Validate the request data
    $request->validate([
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
    ]);

    $eta = Geo::haversineDistance(config('emergency.default.latitude'),config('emergency.default.longitude'),$request->latitude, $request->longitude);
    $avgSpeed = 40; // km/h
    $eta = ceil(($distance / $avgSpeed) * 60); // dalam menit
    
    // Store the emergency data in the database
    $emergency = \App\Models\Emergency::create([
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'eta' => $eta,
    ]);

    EmergencyCalled::dispatch($emergency);

    // Redirect back to the map page with a success message
    return redirect()->intended(route('map', absolute: false));

   }
}
