@extends('layouts.app')
@section('title', 'Machines')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold">Liste des machines</h2>
    <a href="{{ route('machines.create') }}" class="btn-primary text-white px-4 py-2 rounded">+ Nouvelle machine</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Filière</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($machines as $machine)
            <tr>
                <td class="px-6 py-4">{{ $machine->name }}</td>
                <td class="px-6 py-4">{{ $machine->filiere->name }}</td>
                <td class="px-6 py-4">
                    @php
                        $badge = ['fonctionnelle'=>'bg-green-100 text-green-800', 'en_panne'=>'bg-red-100 text-red-800', 'en_maintenance'=>'bg-yellow-100 text-yellow-800'];
                        $label = ['fonctionnelle'=>'Fonctionnelle', 'en_panne'=>'En panne', 'en_maintenance'=>'En maintenance'];
                    @endphp
                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $badge[$machine->status] }}">{{ $label[$machine->status] }}</span>
                </td>
                <td class="px-6 py-4 space-x-2">
                    <a href="{{ route('machines.show', $machine) }}" class="text-blue-600 hover:text-blue-900">Détails</a>
                    <a href="{{ route('machines.edit', $machine) }}" class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                    <form action="{{ route('machines.destroy', $machine) }}" method="POST" class="inline-block" onsubmit="return confirm('Supprimer cette machine ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-6 py-4 border-t">
        {{ $machines->links() }}
    </div>
</div>
@endsection