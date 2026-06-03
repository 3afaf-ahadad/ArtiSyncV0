<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Machine::with('filiere');

        if ($user->isResponsable()) {
            $query->where('filiere_id', $user->filiere_id);
        }

        $total = $query->count();
        $panne = (clone $query)->where('status', 'en_panne')->count();
        $maintenance = (clone $query)->where('status', 'en_maintenance')->count();

        $machines = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('dashboard', compact('machines', 'total', 'panne', 'maintenance'));
    }
}