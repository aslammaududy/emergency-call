<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmergencyResponseController extends Controller
{
    public function index()
    {
        return inertia('EmergencyResponse', [
            'emergencies' => \App\Models\Emergency::latest()->get(),
        ]);
    }

    public function update(Request $request, \App\Models\Emergency $emergency)
    {
        $request->validate([
            'status' => 'required|in:dispatched,completed',
        ]);

        $emergency->update($request->only('status'));

        // App\Events\EmergencyStatusUpdated::dispatch($emergency);

        return redirect()->intended(route('emergency-response', absolute: false));
    }
}
