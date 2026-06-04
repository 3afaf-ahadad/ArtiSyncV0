@extends('layouts.app')
@section('title', 'Modifier une machine')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Modifier la machine</h1>
        <a href="{{ route('machines.index') }}" class="inline-block bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 transition text-sm">
            ← Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('machines.update', $machine) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
                <input type="text" name="name" value="{{ old('name', $machine->name) }}" 
                       class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-[#95651A] focus:border-[#95651A]" required>
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Filière *</label>
                <select name="filiere_id" 
                        class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-[#95651A]" required>
                    @foreach($filieres as $filiere)
                        <option value="{{ $filiere->id }}" {{ $machine->filiere_id == $filiere->id ? 'selected' : '' }}>
                            {{ $filiere->name }}
                        </option>
                    @endforeach
                </select>
                @error('filiere_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Statut *</label>
                <select name="status" 
                        class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-[#95651A]">
                    <option value="fonctionnelle" {{ $machine->status == 'fonctionnelle' ? 'selected' : '' }}>Fonctionnelle</option>
                    <option value="en_panne" {{ $machine->status == 'en_panne' ? 'selected' : '' }}>En panne</option>
                    <option value="en_maintenance" {{ $machine->status == 'en_maintenance' ? 'selected' : '' }}>En maintenance</option>
                </select>
                @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-3 pt-3">
                <a href="{{ route('machines.index') }}" 
                   class="inline-block bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 transition text-sm">
                    Annuler
                </a>
                <button type="submit" 
                        class="btn-primary text-white px-4 py-2 rounded-md hover:bg-[#7a5015] transition text-sm">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection