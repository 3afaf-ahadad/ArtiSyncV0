<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArtiSync - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .btn-primary {
            background-color: #95651A;
        }

        .btn-primary:hover {
            background-color: #7a5115;
        }

        .text-primary {
            color: #95651A;
        }

        .border-primary {
            border-color: #95651A;
        }

        .sidebar-link.active {
            background-color: #95651A;
            color: white !important;
        }

        .sidebar-link.active svg {
            stroke: white;
        }

        /* Top bar styling */
        .top-bar {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.75rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: rgba(149, 101, 26, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #95651A;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar (unchanged) -->
        <aside class="w-64 bg-white shadow-md flex flex-col">
            <div class="p-4 border-b">
                <img src="{{ asset('LOGO.svg') }}" alt="ArtiSync" class="h-10 w-auto">
            </div>
            <nav class="flex-1 mt-6">
                <a href="{{ route('dashboard') }}" class="sidebar-link flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Tableau de bord
                </a>
                <a href="{{ route('machines.index') }}" class="sidebar-link flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('machines.index') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Machines
                </a>
                <a href="{{ route('maintenances.index') }}" class="sidebar-link flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('maintenances.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Maintenances
                </a>
            </nav>
            <div class="p-4 border-t">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center text-red-600 hover:text-red-800">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main content area with top bar -->
        <div class="flex-1 flex flex-col overflow-auto">
            <!-- TOP BAR: user name + role on left, avatar + logout on right -->
            <div class="top-bar">
                <div class="flex justify-between items-center">
                    <!-- Left side: user name and role with icon -->
                    <div class="flex items-center gap-2">
                        <h1 class="text-xl font-semibold text-primary">
                            @if(Auth::user()->isAdmin())
                            Chef de pôle
                            @else
                            Formateur · {{ Auth::user()->filiere->name ?? 'Filière' }}
                            @endif
                        </h1>
                    </div>

                    <!-- Right side: optional actions + avatar + logout -->
                    <div class="flex items-center space-x-4">
                        @hasSection('top_bar_actions')
                        <div class="flex items-center space-x-2">
                            @yield('top_bar_actions')
                        </div>
                        <div class="h-6 w-px bg-gray-300"></div>
                        @endif

                        <!-- Profile avatar -->
                        <div class="flex items-center space-x-2">
                            <div class="avatar">
                                <span>{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <div class="hidden md:block">
                                <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                        </div>

                        <!-- Logout button -->
                        <form method="POST" action="{{ route('logout') }}" class="inline ml-4">
                            @csrf
                            <button type="submit" class="flex items-center text-red-600 hover:text-red-800 text-sm font-medium">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Page content -->
            <main class="flex-1 p-6">
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>