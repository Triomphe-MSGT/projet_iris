@extends('layouts.terrainvente')

@section('title', 'Inscription')

@section('content')
<div class="page-wrap-sm" style="display: flex; justify-content: center; align-items: center; min-height: 70vh;">
    <div class="card card-body" style="width: 100%; max-width: 500px;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="font-size: 1.75rem; font-weight: 900; margin-bottom: 0.5rem;">Créer un compte</h1>
            <p style="color: var(--text-muted);">Rejoignez TerrainVente pour acheter ou vendre des parcelles.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name" class="form-label">Nom complet</label>
                <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Ex: Jean Dupont" />
                @error('name') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">Adresse Email</label>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="votre@email.com" />
                @error('email') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <!-- Phone (if needed on registration) -->
            <div class="form-group">
                <label for="phone" class="form-label">Numéro WhatsApp (Optionnel)</label>
                <input id="phone" class="form-input" type="text" name="phone" value="{{ old('phone') }}" placeholder="Ex: 237690123456" />
                @error('phone') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="grid-2">
                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                    @error('password') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirmez</label>
                    <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                    @error('password_confirmation') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="form-footer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 2rem;">
                <a href="{{ route('login') }}" style="font-size: 0.875rem; color: var(--primary); text-decoration: none;">
                    Déjà inscrit ?
                </a>
                <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem;">
                    S'inscrire
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
