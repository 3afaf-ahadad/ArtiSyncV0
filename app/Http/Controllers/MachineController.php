<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\Filiere;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MachineController extends Controller
{
    /**
     * @param User $user
     * @param Machine $machine
     * @return bool
     */
    protected function authorizeMachine($user, $machine)
    {
        if ($user->isAdmin()) return true;
        return $machine->filiere_id === $user->filiere_id;
    }


    public function index(Request $request)
    {
        $query = Machine::with('filiere');

        // Apply filters
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('filiere')) {
            $query->where('filiere_id', $request->filiere);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Role-based restriction (if not admin)
        if (Auth::check() && Auth::user()->role === 'responsable') {
            $query->where('filiere_id', Auth::user()->filiere_id);
        }

        $machines = $query->paginate(10);
        $filieres = Filiere::all();

        return view('machines.index', compact('machines', 'filieres'));
    }


    public function create()
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->isAdmin()) {
            $filieres = Filiere::all();
        } else {
            $filieres = Filiere::where('id', $user->filiere_id)->get();
        }
        return view('machines.create', compact('filieres'));
    }

    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'filiere_id' => 'required|exists:filieres,id',
            'status' => 'required|in:fonctionnelle,en_panne,en_maintenance',
        ]);

        if ($user->isResponsable() && $data['filiere_id'] != $user->filiere_id) {
            abort(403);
        }

        Machine::create($data);
        return redirect()->route('dashboard')->with('success', 'Machine ajoutée.');
    }

    public function edit(Machine $machine)
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$this->authorizeMachine($user, $machine)) abort(403);

        if ($user->isAdmin()) {
            $filieres = Filiere::all();
        } else {
            $filieres = Filiere::where('id', $user->filiere_id)->get();
        }

        return view('machines.edit', compact('machine', 'filieres'));
    }

    public function update(Request $request, Machine $machine)
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$this->authorizeMachine($user, $machine)) abort(403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'filiere_id' => 'required|exists:filieres,id',
            'status' => 'required|in:fonctionnelle,en_panne,en_maintenance',
        ]);

        if ($user->isResponsable() && $data['filiere_id'] != $user->filiere_id) abort(403);

        $machine->update($data);
        return redirect()->route('dashboard')->with('success', 'Machine modifiée.');
    }

    public function destroy(Machine $machine)
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$this->authorizeMachine($user, $machine)) abort(403);

        $machine->delete();
        return redirect()->route('dashboard')->with('success', 'Machine supprimée.');
    }

    public function show(Machine $machine)
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$this->authorizeMachine($user, $machine)) abort(403);

        $maintenances = $machine->maintenances()->orderBy('date', 'desc')->paginate(10);
        return view('machines.show', compact('machine', 'maintenances'));
    }

}
