<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmergencyResponseController extends Controller
{
    public function index()
    {
        return inertia('EmergencyResponse', [
            'emergencies' => \App\Models\Emergency::all(),
        ]);
    }

    public function store(Request $request)
    {
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
