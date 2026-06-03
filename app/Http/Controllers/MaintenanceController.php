<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    public function store(Request $request, Machine $machine)
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->isResponsable() && $machine->filiere_id !== $user->filiere_id) {
            abort(403);
        }

        $data = $request->validate([
            'date' => 'required|date',
            'description' => 'required|string|max:1000',
        ]);

        $machine->maintenances()->create($data);
        return back()->with('success', 'Intervention ajoutée.');
    }
}