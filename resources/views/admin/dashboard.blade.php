@extends('layouts.terrainvente')

@section('title', 'Administration - TerrainVente')

@section('content')
<div class="page-wrap">
    <div class="dash-top">
        <div>
            <h1 style="font-size: 2rem; font-weight: 900; margin-bottom: 0.25rem; color: var(--primary);">
                Panel Administrateur
            </h1>
            <p style="color: var(--text-muted);">Supervision de la plateforme, gestion des utilisateurs et validation.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-outline">
            Mon tableau de bord (Vendeur)
        </a>
    </div>

    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
            {{ session('error') }}
        </div>
    @endif

    <div class="dash-grid">
        <!-- Dashboard Stats -->
        <div>
            <div class="stat-card" style="border-left: 4px solid var(--primary);">
                <p class="stat-label">Total Utilisateurs</p>
                <p class="stat-value">{{ $users->count() }}</p>
            </div>
            
            <div class="stat-card" style="border-left: 4px solid #3b82f6;">
                <p class="stat-label">Total Terrains Créés</p>
                <p class="stat-value" style="color: #3b82f6;">{{ $totalLands }}</p>
            </div>
        </div>

        <!-- Users Management Table -->
        <div class="table-card">
            <div class="table-header">Gestion des utilisateurs</div>
            
            @forelse($users as $user)
                <div class="table-row">
                    <div class="table-row-meta" style="align-items: center;">
                        <div class="owner-avatar-lg" style="width: 48px; height: 48px;">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <div>
                            <p style="font-weight: 700; font-size: 1rem;">{{ $user->name }}</p>
                            <p style="font-size: 0.8rem; color: var(--text-muted);">
                                {{ $user->email }}
                                @if($user->phone) • {{ $user->phone }} @endif
                            </p>
                        </div>
                    </div>

                    <div class="table-row-actions">
                        <span class="badge badge-gray" style="margin-right: 1rem;">
                            {{ $user->lands_count }} terrain(s)
                        </span>
                        
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Attention: Supprimer cet utilisateur entrainera la suppression définitive de {{ $user->lands_count }} terrains ! Confirmer la suppression ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="icon-btn" title="Bannir et Supprimer l'utilisateur" style="color: #ef4444;" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='var(--bg-body)'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div style="padding: 3rem; text-align: center; color: var(--text-muted);">
                    Aucun utilisateur inscrit pour le moment.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
