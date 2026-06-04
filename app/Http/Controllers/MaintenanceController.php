<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\Maintenance;
use App\Models\Filiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Base query
        $query = Maintenance::with('machine.filiere');

        // Restrict to user's filière if responsable
        if ($user->isResponsable()) {
            $query->whereHas('machine', function ($q) use ($user) {
                $q->where('filiere_id', $user->filiere_id);
            });
        }

        // Search by machine name or description
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhereHas('machine', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by filière
        if ($filiereId = $request->get('filiere')) {
            if ($filiereId !== 'all') {
                $query->whereHas('machine', function ($q) use ($filiereId) {
                    $q->where('filiere_id', $filiereId);
                });
            }
        }

        // Filter by date (exact day)
        if ($date = $request->get('date')) {
            $query->whereDate('date', $date);
        }

        // Order by most recent
        $query->orderBy('date', 'desc')->orderBy('created_at', 'desc');

        // Paginate
        $maintenances = $query->paginate(15);

        // Stats cards
        // 1) Machines en panne (status = en_panne)
        $machinesQuery = Machine::query();
        if ($user->isResponsable()) {
            $machinesQuery->where('filiere_id', $user->filiere_id);
        }
        $machinesEnPanne = $machinesQuery->where('status', 'en_panne')->count();

        // 2) Interventions ce mois (current month)
        $currentMonthInterventions = (clone $query)
            ->whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->count();

        // 3) Total interventions (all, respecting filters? we want global? Keep global)
        $totalInterventions = Maintenance::query();
        if ($user->isResponsable()) {
            $totalInterventions->whereHas('machine', function ($q) use ($user) {
                $q->where('filiere_id', $user->filiere_id);
            });
        }
        $totalInterventions = $totalInterventions->count();

        // For filter dropdowns (admin only)
        $filieres = $user->isAdmin() ? Filiere::all() : collect();

        // Preserve selected values for the view
        $selectedFiliere = $request->get('filiere', 'all');
        $selectedDate = $request->get('date');
        $searchTerm = $request->get('search');

        return view('maintenance.index', compact(
            'maintenances',
            'machinesEnPanne',
            'currentMonthInterventions',
            'totalInterventions',
            'filieres',
            'selectedFiliere',
            'selectedDate',
            'searchTerm'
        ));
    }

    public function store(Request $request, Machine $machine)
    {
        $user = auth()->user();
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