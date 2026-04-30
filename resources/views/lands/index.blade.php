@extends('layouts.terrainvente')

@section('title', 'Accueil – Trouvez votre terrain à Dschang')

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="hero-bg">
        <img src="{{ asset('images/hero_dschang.png') }}" alt="Paysage de Dschang">
        <div class="hero-overlay"></div>
    </div>
    
    <div class="container">
        <div class="hero-content">
            <h1>
                Investissez dans <span>l'avenir</span> du Cameroun.
            </h1>
            <p>
                Découvrez des parcelles de terrain vérifiées et prêtes pour vos projets à Dschang. Une plateforme sécurisée pour des transactions foncières en toute confiance.
            </p>
            <div class="hero-btns">
                <a href="#catalog" class="btn btn-primary">
                    Voir les terrains
                </a>
                <a href="{{ route('lands.create') }}" class="btn btn-outline">
                    Mettre en vente
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features">
    <div class="container">
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                </div>
                <h3>Titres Vérifiés</h3>
                <p>Chaque annonce est soumise à une vérification rigoureuse des titres fonciers par nos administrateurs.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="10" r="3"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M1 21v-2a4 4 0 0 1 3-3.87"></path><path d="M16.84 10a5 5 0 0 0-4.84-4h-4a5 5 0 0 0-4.84 4"></path></svg>
                </div>
                <h3>Expertise Locale</h3>
                <p>Basée à Dschang, notre équipe connaît parfaitement le marché foncier de la Menoua.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                </div>
                <h3>Transactions Rapides</h3>
                <p>Simplifiez vos démarches administratives et concluez vos ventes plus rapidement.</p>
            </div>
        </div>
    </div>
</section>

<!-- Catalog Section -->
<section id="catalog" class="catalog">
    <div class="container">
        <div class="section-header">
            <div>
                <span class="section-tag">Parcourir</span>
                <h2 class="section-title">Terrains à la Une</h2>
            </div>
            <p class="section-desc">Découvrez notre sélection de parcelles disponibles immédiatement dans les meilleurs quartiers de Dschang.</p>
        </div>

        <!-- SEARCH BAR -->
        <div class="search-bar-wrap">
            <form action="{{ route('lands.index') }}#catalog" method="GET" class="search-form">
                <div style="flex: 1; min-width: 250px;">
                    <label for="q" class="form-label" style="font-size: 0.85rem; color: var(--text-muted);">Recherche libre</label>
                    <input type="text" name="q" id="q" class="form-input" value="{{ request('q') }}" placeholder="Ex: Foto, 500m2, titre foncier..." style="padding: 0.75rem;">
                </div>
                
                <div style="width: 150px;">
                    <label for="max_price" class="form-label" style="font-size: 0.85rem; color: var(--text-muted);">Prix Max (FCFA)</label>
                    <input type="number" name="max_price" id="max_price" class="form-input" value="{{ request('max_price') }}" placeholder="Ex: 5000000" style="padding: 0.75rem;">
                </div>
                
                <div class="search-btns">
                    <button type="submit" class="btn btn-primary">
                        Rechercher
                    </button>
                    @if(request()->has('q') || request()->has('max_price'))
                        <a href="{{ route('lands.index') }}#catalog" class="btn btn-outline reset-btn">
                            ✖
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="grid-3">
            @forelse($lands as $land)
                <div class="land-card">
                    <div class="land-image">
                        @if($land->image_path)
                            <img src="{{ asset('storage/' . $land->image_path) }}" alt="{{ $land->title }}">
                        @else
                            <div style="background: var(--primary-light); height: 100%; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.3;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            </div>
                        @endif
                        <div class="land-price">
                            {{ number_format($land->price_cfa, 0, ',', ' ') }} FCFA
                        </div>
                    </div>
                    
                    <div class="land-info">
                        <div class="land-location">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            {{ $land->location }}
                        </div>
                        <h3 class="land-title">{{ $land->title }}</h3>
                        <p class="land-desc">
                            {{ $land->description }}
                        </p>
                        
                        <div class="land-footer">
                            <div class="owner-info">
                                <div class="owner-avatar">
                                    {{ strtoupper(substr($land->owner?->name ?? 'NN', 0, 2)) }}
                                </div>
                                <span style="font-weight: 600; font-size: 0.9rem;">{{ $land->owner?->name ?? 'Vendeur Anonyme' }}</span>
                            </div>
                            <a href="{{ route('lands.show', $land) }}" class="btn btn-outline" style="padding: 0.5rem; border-radius: 10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 0;">
                    <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--text-muted);">Aucune annonce trouvée</h3>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-banner">
    <div class="container">
        <div class="cta-card">
            <h2>
                Prêt à réaliser votre <br/> prochain investissement ?
            </h2>
            <p>
                Rejoignez des centaines d'investisseurs qui font confiance à TerrainVente pour leurs acquisitions à Dschang.
            </p>
            <a href="{{ route('register') }}" class="btn" style="background: white; color: var(--primary); padding: 1.25rem 2.5rem; font-size: 1.1rem; font-weight: 800;">
                Créer un compte gratuitement
            </a>
        </div>
    </div>
</section>
@endsection
