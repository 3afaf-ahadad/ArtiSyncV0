@extends('layouts.app')
@section('title', 'Tableau de bord')

@section('content')
<div class="space-y-6">
    <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Machines</h1>

    <!-- KPIs – horizontal row (always one line, scrollable on mobile) -->
    <div class="flex overflow-x-auto gap-4 lg:gap-6 pb-2">
        <div class="bg-white rounded-lg shadow p-4 min-w-[200px] flex-shrink-0">
            <div>
                <p class="text-gray-500 text-xs sm:text-sm">Total machines</p>
                <p class="text-2xl sm:text-3xl font-bold text-primary">{{ $totalMachines }}</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 min-w-[200px] flex-shrink-0">
            <div>
                <p class="text-gray-500 text-xs sm:text-sm">Machines en panne</p>
                <p class="text-2xl sm:text-3xl font-bold text-red-600">{{ $panne }}</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 min-w-[200px] flex-shrink-0">
            <div>
                <p class="text-gray-500 text-xs sm:text-sm">En maintenance</p>
                <p class="text-2xl sm:text-3xl font-bold text-yellow-600">{{ $maintenance }}</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4 min-w-[200px] flex-shrink-0">
            <div>
                <p class="text-gray-500 text-xs sm:text-sm">Interventions récentes (mois)</p>
                <p class="text-2xl sm:text-3xl font-bold text-primary">{{ $recentMaintenances->count() }}</p>
            </div>
        </div>
    </div>

    @if(Auth::user()->isAdmin())
        <!-- Admin view: two columns (Répartition + Interventions) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left: Répartition par filière -->
            <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                <h2 class="text-base sm:text-lg font-semibold mb-4">Répartition par filière</h2>
                <div class="space-y-3">
                    @foreach($filieres as $filiere)
                    <div class="flex justify-between items-center border-b pb-2">
                        <span class="text-gray-700 text-sm sm:text-base">{{ $filiere->name }}</span>
                        <span class="font-medium text-gray-900 text-sm sm:text-base">{{ $filiere->machines_count }} articles</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Right: Interventions récentes (takes 2/3 width) -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow p-4 sm:p-6">
                <h2 class="text-base sm:text-lg font-semibold mb-4">Interventions récentes</h2>
                <div class="overflow-x-auto -mx-4 sm:-mx-6 px-4 sm:px-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 sm:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Filière</th>
                                <th class="px-3 sm:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-3 sm:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Machine</th>
                                <th class="px-3 sm:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($recentMaintenances as $maint)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 sm:px-4 py-2 text-sm">{{ $maint->machine->filiere->name }}</td>
                                <td class="px-3 sm:px-4 py-2 text-sm">{{ $maint->date->format('d/m/Y') }}</td>
                                <td class="px-3 sm:px-4 py-2 text-sm">{{ $maint->machine->name }}</td>
                                <td class="px-3 sm:px-4 py-2 text-sm">
                                    <a href="{{ route('machines.show', $maint->machine) }}" class="text-blue-600 hover:text-blue-800">Détails</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-500">Aucune intervention récente</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($recentMaintenances->count() > 0)
                <div class="mt-4 text-right">
                    <a href="{{ route('maintenances.index') }}" class="text-primary hover:underline text-sm">Voir plus →</a>
                </div>
                @endif
            </div>
        </div>
    @else
        <!-- Formateur (responsable) view: only interventions, full width -->
        <div class="bg-white rounded-lg shadow p-4 sm:p-6">
            <h2 class="text-base sm:text-lg font-semibold mb-4">Interventions récentes</h2>
            <div class="overflow-x-auto -mx-4 sm:-mx-6 px-4 sm:px-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 sm:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Filière</th>
                            <th class="px-3 sm:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-3 sm:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Machine</th>
                            <th class="px-3 sm:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentMaintenances as $maint)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 sm:px-4 py-2 text-sm">{{ $maint->machine->filiere->name }}</td>
                            <td class="px-3 sm:px-4 py-2 text-sm">{{ $maint->date->format('d/m/Y') }}</td>
                            <td class="px-3 sm:px-4 py-2 text-sm">{{ $maint->machine->name }}</td>
                            <td class="px-3 sm:px-4 py-2 text-sm">
                                <a href="{{ route('machines.show', $maint->machine) }}" class="text-blue-600 hover:text-blue-800">Détails</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500">Aucune intervention récente</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($recentMaintenances->count() > 0)
            <div class="mt-4 text-right">
                <a href="{{ route('maintenances.index') }}" class="text-primary hover:underline text-sm">Voir plus →</a>
            </div>
            @endif
        </div>
    @endif
</div>
@endsection