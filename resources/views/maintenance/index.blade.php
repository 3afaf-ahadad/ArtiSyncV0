@extends('layouts.app')
@section('title', 'Gestion des interventions')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold">Gestion des interventions</h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
    <!-- Machines en panne -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-xs sm:text-sm">Machines en panne</p>
                <p class="text-2xl sm:text-3xl font-bold text-red-600">{{ $machinesEnPanne }}</p>
                <p class="text-xs text-gray-400 mt-1">Intervention urgente requise</p>
            </div>
            <svg class="w-6 h-6 sm:w-8 sm:h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
    </div>

    <!-- Interventions totales -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-xs sm:text-sm">Interventions totales</p>
                <p class="text-2xl sm:text-3xl font-bold text-primary">{{ $totalInterventions }}</p>
            </div>
            <svg class="w-6 h-6 sm:w-8 sm:h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
        </div>
    </div>

    <!-- Ce mois-ci -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-xs sm:text-sm">Ce mois-ci</p>
                <p class="text-2xl sm:text-3xl font-bold text-primary">{{ $currentMonthInterventions }}</p>
            </div>
            <svg class="w-6 h-6 sm:w-8 sm:h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
    </div>
</div>

    <!-- Filter bar -->
<div class="bg-white rounded-lg shadow p-2 mb-4 ">
    <form method="GET" action="{{ route('maintenances.index') }}" class="flex flex-wrap items-end gap-4">
        <!-- Search field -->
        <div class="flex-1 min-w-[150px]">
            <label class="block text-sm font-medium text-gray-700 mb-1">Rechercher</label>
            <input type="text" name="search" value="{{ $searchTerm }}" placeholder="ID Machine, Nom..." class="w-full px-3 py-2 border rounded-md">
        </div>

        <!-- Filière (only for admin) -->
        @if(Auth::user()->isAdmin())
        <div class="w-48">
            <label class="block text-sm font-medium text-gray-700 mb-1">Filière</label>
            <select name="filiere" class="w-full px-3 py-2 border rounded-md">
                <option value="all" {{ $selectedFiliere == 'all' ? 'selected' : '' }}>Toutes</option>
                @foreach($filieres as $filiere)
                    <option value="{{ $filiere->id }}" {{ $selectedFiliere == $filiere->id ? 'selected' : '' }}>
                        {{ $filiere->name }}
                    </option>
                @endforeach
            </select>
        </div>
        @endif

        <!-- Date filter -->
        <div class="w-48">
            <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
            <input type="date" name="date" value="{{ $selectedDate }}" class="w-full px-3 py-2 border rounded-md">
        </div>

        <!-- Buttons -->
        <div class="flex gap-2">
            <button type="submit" class="btn-primary text-white px-4 py-2 rounded-md text-sm">Filtrer</button>
            <a href="{{ route('maintenances.index') }}" class="inline-block bg-gray-200 text-gray-800 px-4 py-6 rounded-md hover:bg-gray-300 transition text-center">Réinitialiser</a>
        </div>
    </form>
</div>
    <!-- Interventions table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Machine</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Filière</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($maintenances as $maint)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $maint->date->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $maint->machine->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $maint->machine->filiere->name }}</td>
                    <td class="px-6 py-4 text-sm">{{ $maint->description }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('machines.show', $maint->machine) }}" class="text-blue-600 hover:text-blue-800">Voir machine</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">Aucune intervention trouvée</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t">
            {{ $maintenances->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection