<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

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

    // Store the emergency data in the database
    \App\Models\Emergency::create($request->all());

    // Redirect back to the map page with a success message
    return redirect()->intended(route('map', absolute: false));

   }
}
