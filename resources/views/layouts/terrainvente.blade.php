<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TerrainVente') – Gestion Foncière Dschang</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Instrument-sans:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts / Styles -->
    <!-- Scripts / Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- Alpine.js & Axios (CDNs) -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        window.axios = axios;
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Mobile Menu Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuBtn = document.getElementById('mobile-menu-btn');
            const navLinks = document.getElementById('nav-links');
            if (menuBtn && navLinks) {
                menuBtn.addEventListener('click', () => {
                    navLinks.classList.toggle('active');
                });
            }
        });
    </script>
</head>
<body class="antialiased">

    <!-- Header / Navigation TerrainVente -->
    <header>
        <div class="container header-inner">
            <!-- Logo -->
            <a href="{{ route('lands.index') }}" class="logo">
                TerrainVente
                <span class="logo-tag">Dschang</span>
            </a>

            <!-- Navigation Links -->
            <nav class="nav-links" id="nav-links">
                <ul>
                    <li><a href="{{ route('lands.index') }}">Explorer</a></li>
                    @auth
                        @can('admin-access')
                            <li><a href="{{ route('admin.dashboard') }}" style="color: #ef4444; font-weight: 700;">Admin</a></li>
                        @endcan
                        <li><a href="{{ route('lands.create') }}">+ Publier</a></li>
                        <li><a href="{{ route('dashboard') }}">Mes Terrains</a></li>
                        <li><a href="{{ route('profile.edit') }}">Mon Profil</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-outline" style="padding: 0.5rem 1rem; font-size:0.8rem; border-radius: 8px;">Déconnexion</button>
                            </form>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}">Connexion</a></li>
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}" class="btn btn-primary" style="padding: 0.5rem 1.25rem;">S'inscrire</a></li>
                        @endif
                    @endauth
                </ul>
            </nav>

            <!-- Hamburger Button for Mobile -->
            <button class="mobile-menu-btn" id="mobile-menu-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div class="container" style="padding-top: 1rem;">
                <div style="background: var(--primary-light); color: var(--primary-hover); padding: 1rem; border-radius: 12px; border: 1px solid var(--primary); margin-bottom: 1rem; font-weight: 600;">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} <span class="brand">TerrainVente</span> – Projet Iris. Plateforme de gestion foncière à Dschang, Cameroun.</p>
        </div>
    </footer>

</body>
</html>

