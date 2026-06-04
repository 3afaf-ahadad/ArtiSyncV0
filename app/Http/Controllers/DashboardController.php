<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\Maintenance;
use App\Models\Filiere;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Base query for machines (respect role)
        $query = Machine::query();
        if ($user->isResponsable()) {
            $query->where('filiere_id', $user->filiere_id);
        }

        $totalMachines = $query->count();
        $panne = (clone $query)->where('status', 'en_panne')->count();
        $maintenance = (clone $query)->where('status', 'en_maintenance')->count();

        // Recent maintenances (last 5)
        $maintenancesQuery = Maintenance::with('machine.filiere')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc');
        if ($user->isResponsable()) {
            $maintenancesQuery->whereHas('machine', function ($q) use ($user) {
                $q->where('filiere_id', $user->filiere_id);
            });
        }
        $recentMaintenances = $maintenancesQuery->limit(5)->get();

        // Répartition par filière
        $filieres = Filiere::withCount('machines')->get();

        return view('dashboard', compact(
            'totalMachines', 'panne', 'maintenance',
            'recentMaintenances', 'filieres', 'user'
        ));
    }
}