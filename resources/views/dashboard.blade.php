@extends('layouts.app')
@section('title', 'Tableau de bord')

@section('content')
<div class="space-y-6">
    <!-- Welcome message -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">
            Bienvenue {{ Auth::user()->name }}
        </h1>
        <div class="text-sm text-gray-500">
            @if(Auth::user()->isAdmin())
                Chef de pôle CP
            @else
                Formateur - {{ Auth::user()->filiere->name }}
            @endif
        </div>
    </div>

    <!-- Top row: 4 cards (Total, Panne, Maintenance, Interventions récentes mois) -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total machines</p>
                    <p class="text-3xl font-bold text-primary">{{ $totalMachines }}</p>
                </div>
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Machines en panne</p>
                    <p class="text-3xl font-bold text-red-600">{{ $panne }}</p>
                </div>
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">En maintenance</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $maintenance }}</p>
                </div>
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Interventions récentes (mois)</p>
                    <p class="text-3xl font-bold text-primary">{{ $recentMaintenances->count() }}</p>
                </div>
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Two columns: Répartition par filière + Interventions récentes -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Répartition par filière -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Répartition par filière</h2>
            <div class="space-y-3">
                @foreach($filieres as $filiere)
                <div class="flex justify-between items-center border-b pb-2">
                    <span class="text-gray-700">{{ $filiere->name }}</span>
                    <span class="font-medium text-gray-900">{{ $filiere->machines_count }} articles</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Right: Interventions récentes -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Interventions récentes</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Filière</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Machine</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentMaintenances as $maint)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $maint->machine->filiere->name }}</td>
                            <td class="px-4 py-2">{{ $maint->date->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">{{ $maint->machine->name }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('machines.show', $maint->machine) }}" class="text-blue-600 hover:text-blue-800 text-sm">Détails</a>
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
</div>
@endsection