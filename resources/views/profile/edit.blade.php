@extends('layouts.terrainvente')

@section('title', 'Mon Profil')

@section('content')
<div class="page-wrap-sm">
    <div class="page-header">
        <h1>Mon Profil</h1>
        <p>Gérez vos informations personnelles et paramètres de sécurité.</p>
    </div>

    <div style="display: flex; flex-direction: column; gap: 2rem;">
        
        <!-- Informations du profil (dont le Numéro WhatsApp) -->
        <div class="card card-body">
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Modifier le mot de passe -->
        <div class="card card-body">
            @include('profile.partials.update-password-form')
        </div>

        <!-- Supprimer le compte -->
        <div class="card card-body" style="border-left: 4px solid #ef4444;">
            @include('profile.partials.delete-user-form')
        </div>

    </div>
</div>

<style>
    /* Surcouche CSS rapide pour corriger les classes Tailwind résiduelles de Breeze dans les partials */
    .mt-6 { margin-top: 1.5rem; }
    .mt-4 { margin-top: 1rem; }
    .mt-2 { margin-top: 0.5rem; }
    .space-y-6 > * + * { margin-top: 1.5rem; }
    .block { display: block; }
    .w-full { width: 100%; }
    .font-medium { font-weight: 600; }
    .text-lg { font-size: 1.125rem; margin-bottom: 0.25rem; }
    .text-sm { font-size: 0.875rem; }
    .text-gray-900 { color: var(--text-main); }
    .text-gray-600 { color: var(--text-muted); }
    .text-red-600 { color: #dc2626; }
    h2 { font-weight: 800; font-size: 1.3rem; margin-bottom: 0.25rem; }
    header p { margin-bottom: 1.5rem; }
    .flex { display: flex; }
    .items-center { align-items: center; }
    .gap-4 { gap: 1rem; }
    
    /* Boutons dans le profil */
    button, input[type="submit"] {
        background: var(--bg-card);
        color: var(--text-main);
        font-family: 'Inter', sans-serif;
    }
    .flex > button {
        background: var(--primary);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        cursor: pointer;
    }
    
    /* Remplacer x-text-input tailwind par nos form-input natifs */
    input[type='text'], input[type='email'], input[type='password'] {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid var(--border-soft);
        border-radius: 10px;
        outline: none;
        transition: 0.2s;
    }
    input[type='text']:focus, input[type='email']:focus, input[type='password']:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px var(--primary-light);
    }
</style>
@endsection
