<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\Maintenance;
use App\Models\Filiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Get filter values
        $selectedFiliere = $request->get('filiere');
        $selectedStatus = $request->get('status');

        // Base query for machines (respect role)
        $query = Machine::query();
        if ($user->isResponsable()) {
            $query->where('filiere_id', $user->filiere_id);
        }

        // Apply filtre filière (only for admin)
        if ($user->isAdmin() && $selectedFiliere && $selectedFiliere !== 'all') {
            $query->where('filiere_id', $selectedFiliere);
        }

        // Apply status filter
        if ($selectedStatus && $selectedStatus !== 'all') {
            $query->where('status', $selectedStatus);
        }

        $totalMachines = $query->count();
        $panne = (clone $query)->where('status', 'en_panne')->count();
        $maintenance = (clone $query)->where('status', 'en_maintenance')->count();

        // Recent maintenances (last 5) with same filters
        $maintenancesQuery = Maintenance::with('machine.filiere')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc');

        // Apply role filter
        if ($user->isResponsable()) {
            $maintenancesQuery->whereHas('machine', function ($q) use ($user) {
                $q->where('filiere_id', $user->filiere_id);
            });
        }

        // Apply filière filter (if admin and selected)
        if ($user->isAdmin() && $selectedFiliere && $selectedFiliere !== 'all') {
            $maintenancesQuery->whereHas('machine', function ($q) use ($selectedFiliere) {
                $q->where('filiere_id', $selectedFiliere);
            });
        }

        // Apply status filter (via machine status)
        if ($selectedStatus && $selectedStatus !== 'all') {
            $maintenancesQuery->whereHas('machine', function ($q) use ($selectedStatus) {
                $q->where('status', $selectedStatus);
            });
        }

        $recentMaintenances = $maintenancesQuery->limit(5)->get();

        // Répartition par filière (always show all filières, but counts are filtered by status if needed)
        $filieres = Filiere::withCount(['machines' => function ($q) use ($selectedStatus, $user, $selectedFiliere) {
            if ($user->isResponsable()) {
                $q->where('filiere_id', $user->filiere_id);
            }
            if ($selectedStatus && $selectedStatus !== 'all') {
                $q->where('status', $selectedStatus);
            }
            // For admin, the filière filter is already applied via the filiere_id condition below
        }])->get();

        // If admin and a specific filière is selected, only show that filière in repartition
        if ($user->isAdmin() && $selectedFiliere && $selectedFiliere !== 'all') {
            $filieres = $filieres->filter(function ($filiere) use ($selectedFiliere) {
                return $filiere->id == $selectedFiliere;
            });
        }

        // Get list of filières for filter dropdown (admin only)
        $filiereList = $user->isAdmin() ? Filiere::all() : collect();

        return view('dashboard', compact(
            'totalMachines', 'panne', 'maintenance',
            'recentMaintenances', 'filieres', 'user',
            'selectedFiliere', 'selectedStatus', 'filiereList'
        ));
    }
}