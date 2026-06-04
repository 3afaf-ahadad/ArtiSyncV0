@extends('layouts.app')
@section('title', $machine->name)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h1 class="text-2xl font-bold mb-4">{{ $machine->name }}</h1>
        <div class="grid grid-cols-2 gap-4">
            <div><span class="text-gray-600">Filière :</span> <strong>{{ $machine->filiere->name }}</strong></div>
            <div><span class="text-gray-600">Statut :</span> <strong>{{ ucfirst(str_replace('_',' ',$machine->status)) }}</strong></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Ajouter une intervention</h2>
        <form method="POST" action="{{ route('maintenances.store', $machine) }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Date</label>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-md" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Description</label>
                    <input type="text" name="description" class="w-full border-gray-300 rounded-md" required>
                </div>
            </div>
            <button type="submit" class="btn-primary text-white px-4 py-2 rounded-md">Ajouter</button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Historique des interventions</h2>
        @if($maintenances->count())
            <div class="space-y-3">
                @foreach($maintenances as $maint)
                    <div class="border-l-4 pl-4" style="border-left-color: #95651A;">
                        <div class="font-medium">{{ $maint->date->format('d/m/Y') }}</div>
                        <div class="text-gray-700">{{ $maint->description }}</div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Aucune intervention enregistrée.</p>
        @endif
    </div>
</div>
@endsection