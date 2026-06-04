@extends('layouts.app')
@section('title', 'Gestion des maintenances')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Historique des interventions</h2>
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-4 py-2">Date</th>
                <th class="px-4 py-2">Machine</th>
                <th class="px-4 py-2">Filière</th>
                <th class="px-4 py-2">Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($maintenances as $m)
            <tr>
                <td class="px-4 py-2">{{ $m->date->format('d/m/Y') }}</td>
                <td class="px-4 py-2">{{ $m->machine->name }}</td>
                <td class="px-4 py-2">{{ $m->machine->filiere->name }}</td>
                <td class="px-4 py-2">{{ $m->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $maintenances->links() }}
    </div>
</div>
@endsection