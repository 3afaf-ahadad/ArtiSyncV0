@extends('layouts.app')
@section('title', 'Machines')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold">Liste des machines</h2>
    <a href="{{ route('machines.create') }}" class="btn-primary text-white px-4 py-2 rounded">+ Nouvelle machine</a>
</div>

<!-- Filter Form -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" action="{{ route('machines.index') }}" class="flex flex-wrap items-end gap-4">
        <div class="flex-1 min-w-[150px]">
            <label class="block text-sm font-medium text-gray-700 mb-1">Rechercher (nom ou ID)</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom ou ID" class="w-full px-3 py-2 border rounded-md">
        </div>
        <div rrclass="w-40">
            <label class="block text-sm font-medium text-gray-700 mb-1">Filière</label>
            <select name="filiere" class="w-full px-3 py-2 border rounded-md">
                <option value="">Toutes</option>
                @foreach($filieres as $filiere)
                <option value="{{ $filiere->id }}" {{ request('filiere') == $filiere->id ? 'selected' : '' }}>{{ $filiere->name }}</option>
                @endforeach
            </select>
        </div>
        <iv class="w-44">
            <label class="block text-sm font-medium text-gray-700 mb-1">Date début</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-3 py-2 border rounded-md">
        </iv>
        <div class="w-44">
            <label class="block text-sm font-medium text-gray-700 mb-1">Date fin</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full px-3 py-2 border rounded-md">
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="btn-primary text-white px-4 py-2 rounded-md text-sm h-[42px] inline-flex items-center">
                Rechercher
            </button>
            <a href="{{ route('machines.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md text-sm h-[42px] inline-flex items-center">
                Réinitialiser
            </a>
        </div>
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Filière</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Créé le</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($machines as $machine)
            <tr>
                <td class="px-6 py-4">{{ $machine->id }}</td>
                <td class="px-6 py-4">{{ $machine->name }}</td>
                <td class="px-6 py-4">{{ $machine->filiere->name }}</td>
                <td class="px-6 py-4">
                    @php
                    $badge = ['fonctionnelle'=>'bg-green-100 text-green-800', 'en_panne'=>'bg-red-100 text-red-800', 'en_maintenance'=>'bg-yellow-100 text-yellow-800'];
                    $label = ['fonctionnelle'=>'Fonctionnelle', 'en_panne'=>'En panne', 'en_maintenance'=>'En maintenance'];
                    @endphp
                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $badge[$machine->status] }}">{{ $label[$machine->status] }}</span>
                </td>
                <td class="px-6 py-4">{{ $machine->created_at->format('d/m/Y') }}</td>
                <td class="px-6 py-4 space-x-2">
<div class="flex items-center gap-3">
    <!-- Détails (eye icon) -->
    <a href="{{ route('machines.show', $machine) }}" class="text-blue-600 hover:text-blue-800 transition" title="Détails">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
        <span class="sr-only">Détails</span>
    </a>

    <!-- Modifier (pencil icon) -->
    <a href="{{ route('machines.edit', $machine) }}" class="text-indigo-600 hover:text-indigo-800 transition" title="Modifier">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
        <span class="sr-only">Modifier</span>
    </a>

    <!-- Supprimer (trash icon) -->
    <form action="{{ route('machines.destroy', $machine) }}" method="POST" class="inline-block" onsubmit="return confirm('Supprimer cette machine ?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 hover:text-red-800 transition" title="Supprimer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            <span class="sr-only">Supprimer</span>
        </button>
    </form>
</div>                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-6 py-4 border-t">
        {{ $machines->appends(request()->query())->links() }}
    </div>
</div>
@endsection