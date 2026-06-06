<x-guest-layout>
    <!-- Override default guest layout content completely -->
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <!-- Logo -->
            <div class="text-center mb-8">
                <img src="{{ asset('LOGO.svg') }}" alt="ArtiSync Logo" class=" w-auto mx-auto">
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nom@example.com" required autofocus
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#95651A] focus:border-[#95651A]">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Password with lock icon -->
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#95651A] focus:border-[#95651A] pr-10">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                            🔒
                        </span>
                    </div>
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" name="remember"
                               class="rounded border-gray-300 text-[#95651A] shadow-sm focus:ring-[#95651A]">
                        <span class="ms-2 text-sm text-gray-600">Se souvenir de moi</span>
                    </label>
                </div>

                <!-- Submit button -->
                <div class="flex items-center justify-end mt-4">
                    
                    <x-primary-button class="ms-3" style="background-color: #95651A;" type="submit">

                        Se connecter →
                    </x-primary-button>
                </div>
            </form>

            <!-- Footer -->
            <div class="text-center mt-8 pt-4 border-t border-gray-200 text-xs text-gray-400">
                2026 © ArtiSync - CMC CS
            </div>
        </div>
    </div>
</x-guest-layout>