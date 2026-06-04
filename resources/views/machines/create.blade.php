@extends('layouts.app')
@section('title', 'Ajouter une machine')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Ajouter une machine</h1>
    <form method="POST" action="{{ route('machines.store') }}" class="bg-white rounded-lg shadow p-6">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Nom *</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border-gray-300 rounded-md" required>
            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Filière *</label>
            <select name="filiere_id" class="w-full border-gray-300 rounded-md" required>
                @foreach($filieres as $filiere)
                    <option value="{{ $filiere->id }}">{{ $filiere->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium mb-2">Statut *</label>
            <select name="status" class="w-full border-gray-300 rounded-md">
                <option value="fonctionnelle">Fonctionnelle</option>
                <option value="en_panne">En panne</option>
                <option value="en_maintenance">En maintenance</option>
            </select>
        </div>
        <div class="flex justify-end space-x-3">
            <a href="{{ route('dashboard') }}" class="px-4 py-2 border rounded-md">Annuler</a>
            <button type="submit" class="btn-primary text-white px-4 py-2 rounded-md">Créer</button>
        </div>
    </form>
</div>
@endsection