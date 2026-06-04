@extends('layouts.app')
@section('title', $machine->name)

@section('content')
<div class="space-y-6">
    <!-- Header with back button -->
    <div class="flex justify-between items-center">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-800">{{ $machine->name }}</h1>
        <a href="{{ route('machines.index') }}" class="inline-block bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 transition text-sm">
            ← Retour à la liste
        </a>
    </div>

    <!-- Machine details card -->
    <div class="bg-white rounded-lg shadow p-4 sm:p-6">
        <h2 class="text-base sm:text-lg font-semibold mb-4 text-gray-800">Informations générales</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <span class="text-sm text-gray-500">Filière</span>
                <p class="font-medium text-gray-900">{{ $machine->filiere->name }}</p>
            </div>
            <div>
                <span class="text-sm text-gray-500">Statut</span>
                <p>
                    @php
                        $badge = [
                            'fonctionnelle' => 'bg-green-100 text-green-800',
                            'en_panne' => 'bg-red-100 text-red-800',
                            'en_maintenance' => 'bg-yellow-100 text-yellow-800'
                        ];
                        $label = [
                            'fonctionnelle' => 'Fonctionnelle',
                            'en_panne' => 'En panne',
                            'en_maintenance' => 'En maintenance'
                        ];
                    @endphp
                    <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium {{ $badge[$machine->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $label[$machine->status] ?? ucfirst(str_replace('_', ' ', $machine->status)) }}
                    </span>
                </p>
            </div>
        </div>
    </div>

    <!-- Add maintenance card -->
    <div class="bg-white rounded-lg shadow p-4 sm:p-6">
        <h2 class="text-base sm:text-lg font-semibold mb-4 text-gray-800">Ajouter une intervention</h2>
        <form method="POST" action="{{ route('maintenances.store', $machine) }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-[#95651A] focus:border-[#95651A]" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <input type="text" name="description" placeholder="Ex: Remplacement courroie" class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-[#95651A]" required>
                </div>
                <span> </span>
            </div>
            <div>
                <button type="submit"
                        class="btn-primary text-white px-4 py-2 my-2 rounded-md hover:bg-[#7a5015] transition text-sm"

                >Ajouter l'intervention</button>
            </div>
        </form>
    </div>

    <!-- Maintenance history card -->
    <div class="bg-white rounded-lg shadow p-4 sm:p-6">
        <h2 class="text-base sm:text-lg font-semibold mb-4 text-gray-800">Historique des interventions</h2>
        @if($maintenances->count())
            <div class="space-y-3">
                @foreach($maintenances as $maint)
                    <div class="border-l-4 pl-4 py-2" style="border-left-color: #95651A;">
                        <div class="text-sm font-medium text-gray-900">{{ $maint->date->format('d/m/Y') }}</div>
                        <div class="text-sm text-gray-600">{{ $maint->description }}</div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $maintenances->links() }}
            </div>
        @else
            <p class="text-gray-500 text-sm">Aucune intervention enregistrée pour cette machine.</p>
        @endif
    </div>
</div>
@endsection