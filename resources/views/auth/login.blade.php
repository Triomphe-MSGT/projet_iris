@extends('layouts.terrainvente')

@section('title', 'Connexion')

@section('content')
<div class="page-wrap-sm" style="display: flex; justify-content: center; align-items: center; min-height: 70vh;">
    <div class="card card-body" style="width: 100%; max-width: 450px;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="font-size: 1.75rem; font-weight: 900; margin-bottom: 0.5rem;">Connexion</h1>
            <p style="color: var(--text-muted);">Accédez à votre compte TerrainVente.</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.875rem;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">Adresse Email</label>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="votre@email.com" />
                @error('email') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Mot de passe</label>
                <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                @error('password') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <!-- Remember Me -->
            <div class="form-group" style="display: flex; align-items: center; margin-top: 1rem;">
                <input id="remember_me" type="checkbox" name="remember" style="margin-right: 0.5rem; accent-color: var(--primary); width: 16px; height: 16px;">
                <label for="remember_me" style="font-size: 0.875rem; color: var(--text-muted); cursor: pointer;">Se souvenir de moi</label>
            </div>

            <div class="form-footer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 2rem;">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size: 0.875rem; color: var(--primary); text-decoration: none;">
                        Mot de passe oublié ?
                    </a>
                @endif
                <button type="submit" class="btn btn-primary">
                    Se connecter
                </button>
            </div>
        </form>

        <div style="text-align: center; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-soft);">
            <p style="font-size: 0.875rem; color: var(--text-muted);">
                Pas encore de compte ? <a href="{{ route('register') }}" style="color: var(--primary); font-weight: 600; text-decoration: none;">S'inscrire</a>
            </p>
        </div>
    </div>
</div>
@endsection
