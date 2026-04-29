@extends('layouts.terrainvente')

@section('title', 'Mon Tableau de Bord')

@section('content')
<div class="page-wrap">
    <div class="dash-top">
        <div>
            <h1 style="font-size:2rem;font-weight:900;margin-bottom:.25rem;">Bonjour, {{ Auth::user()->name }}</h1>
            <p style="color:var(--text-muted);">Gérez vos annonces et suivez vos transactions foncières.</p>
        </div>
        <a href="{{ route('lands.create') }}" class="btn btn-primary">
            Nouvelle Annonce
        </a>
    </div>

    <div class="dash-grid">
        <!-- Stats -->
        <div>
            <div class="stat-card">
                <p class="stat-label">Total Annonces</p>
                <p class="stat-value">{{ $myLands->count() }}</p>
            </div>
            <div class="stat-card">
                <p class="stat-label">Ventes Réussies</p>
                <p class="stat-value green">{{ $myLands->where('status', 'vendu')->count() }}</p>
            </div>
        </div>

        <!-- List -->
        <div class="table-card">
            <div class="table-header">Vos Parcelles</div>
            @forelse($myLands as $land)
                <div class="table-row">
                    <div class="table-row-meta">
                        <div class="thumb-sm">
                            @if($land->image_path)
                                <img src="{{ asset('storage/' . $land->image_path) }}" alt="{{ $land->title }}">
                            @else
                                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:var(--text-light);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <p style="font-weight:700;font-size:.9rem;">{{ $land->title }}</p>
                            <p style="font-size:.75rem;color:var(--text-muted);">{{ $land->location }} • {{ number_format($land->price_cfa, 0, ',', ' ') }} FCFA</p>
                        </div>
                    </div>

                    <div class="table-row-actions">
                        @php
                            $badgeClass = match($land->status) {
                                'disponible' => 'badge-green',
                                'vendu'      => 'badge-gray',
                                default      => 'badge-yellow',
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $land->status }}</span>

                        <a href="{{ route('lands.show', $land) }}" class="icon-btn" title="Voir">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </a>
                        <a href="{{ route('lands.edit', $land) }}" class="icon-btn edit" title="Modifier">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div style="padding:3rem;text-align:center;color:var(--text-muted);">
                    Vous n'avez pas encore d'annonces.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
