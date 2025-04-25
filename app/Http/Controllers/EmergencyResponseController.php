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

}
