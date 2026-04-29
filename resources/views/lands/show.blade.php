@extends('layouts.terrainvente')

@section('title', $land->title)

@section('content')
<div class="page-wrap">
    <div class="show-grid">
        <!-- Media Gallery -->
        <div>
            <div class="land-aspect">
                @if($land->image_path)
                    <img src="{{ asset('storage/' . $land->image_path) }}" alt="{{ $land->title }}">
                @else
                    <div style="width:100%;height:100%;background:var(--bg-alt);display:flex;flex-direction:column;align-items:center;justify-content:center;color:var(--text-light);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="opacity:.2;margin-bottom:.75rem;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        <p style="font-size:.85rem;">Aucune image disponible</p>
                    </div>
                @endif
            </div>

            <div class="thumb-grid">
                <div class="thumb-placeholder"></div>
                <div class="thumb-placeholder"></div>
                <div class="thumb-placeholder"></div>
                <div class="thumb-placeholder"></div>
            </div>
        </div>

        <!-- Details -->
        <div>
            <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1rem;">
                @php
                    $badgeClass = match($land->status) {
                        'disponible' => 'badge-green',
                        'vendu'      => 'badge-gray',
                        default      => 'badge-yellow',
                    };
                @endphp
                <span class="badge {{ $badgeClass }}">{{ $land->status }}</span>
                <span class="location-meta">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    {{ $land->location }}
                </span>
            </div>

            <h1 style="font-size:2.25rem;font-weight:900;line-height:1.1;margin-bottom:1rem;">{{ $land->title }}</h1>

            <div class="price-big" style="margin-bottom:2rem;">
                {{ number_format($land->price_cfa, 0, ',', ' ') }}<span>FCFA</span>
            </div>

            <div class="card card-body" style="margin-bottom:1.5rem;">
                <p class="section-label">Description</p>
                <p style="font-size:.95rem;line-height:1.7;color:var(--text-muted);">{{ $land->description }}</p>
            </div>

            <div class="owner-card">
                <div class="owner-avatar-lg">
                    {{ strtoupper(substr($land->owner?->name ?? 'NN', 0, 2)) }}
                </div>
                <div>
                    <p style="font-size:.75rem;color:var(--text-muted);">Propriétaire</p>
                    <p style="font-weight:700;">{{ $land->owner?->name ?? 'Inconnu' }}</p>
                </div>
            </div>

            @guest
                <div style="display:flex;flex-direction:column;gap:1rem;">
                    <a href="{{ route('login') }}" class="btn btn-secondary btn-full" style="padding:1rem;justify-content:center;">
                        Se connecter pour acheter
                    </a>
                    
                    @if($land->owner && $land->owner->phone)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $land->owner->phone) }}?text={{ urlencode('Bonjour, je suis intéressé par votre terrain "' . $land->title . '" à ' . number_format($land->price_cfa, 0, ',', ' ') . ' FCFA. Est-il toujours disponible ?') }}" target="_blank" class="btn btn-outline btn-full" style="padding:1rem;justify-content:center;border-color:#25D366;color:#25D366;gap:0.5rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                            Contacter via WhatsApp
                        </a>
                    @endif
                </div>
            @else
                @if($land->user_id !== Auth::id())
                    <div style="display:flex;flex-direction:column;gap:1rem;">
                        <a href="{{ route('lands.checkout', $land) }}" class="btn btn-primary btn-full" style="padding:1rem;font-size:1rem;justify-content:center;">
                            Acheter maintenant
                        </a>
                        
                        @if($land->owner && $land->owner->phone)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $land->owner->phone) }}?text={{ urlencode('Bonjour, je suis intéressé par votre terrain "' . $land->title . '" à ' . number_format($land->price_cfa, 0, ',', ' ') . ' FCFA. Est-il toujours disponible ?') }}" target="_blank" class="btn btn-outline btn-full" style="padding:1rem;justify-content:center;border-color:#25D366;color:#25D366;gap:0.5rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                Contacter via WhatsApp
                            </a>
                        @endif
                    </div>
                @else
                    <div style="display:flex;gap:1rem;">
                        <a href="{{ route('lands.edit', $land) }}" class="btn btn-secondary" style="flex:1;justify-content:center;padding:.9rem;">
                            Modifier l'annonce
                        </a>
                        <form action="{{ route('lands.destroy', $land) }}" method="POST" style="flex:1;" onsubmit="return confirm('Supprimer définitivement cette annonce ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-full" style="padding:.9rem;justify-content:center;">
                                Supprimer
                            </button>
                        </form>
                    </div>
                @endif
            @endguest
        </div>
    </div>
</div>
@endsection
