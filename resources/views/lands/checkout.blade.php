@extends('layouts.terrainvente')

@section('title', 'Finaliser l\'achat')

@section('content')
<div class="page-wrap-sm" style="display: flex; justify-content: center; min-height: 70vh;">
    <div class="card card-body" style="width: 100%; max-width: 600px;">
        <div class="page-header" style="text-align: center;">
            <a href="{{ route('lands.show', $land) }}" class="back-link" style="justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Retour à l'annonce
            </a>
            <h1>Paiement Sécurisé</h1>
            <p>Finalisez l'achat de <strong>{{ $land->title }}</strong></p>
        </div>

        <div style="background: var(--bg-alt); padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                <span style="color: var(--text-muted);">Montant à payer</span>
                <span style="font-weight: 900; font-size: 1.25rem;">{{ number_format($land->price_cfa, 0, ',', ' ') }} FCFA</span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span style="color: var(--text-muted);">Localisation</span>
                <span style="font-weight: 600;">{{ $land->location }}</span>
            </div>
        </div>

        @if(session('error'))
            <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('lands.purchase', $land) }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label" style="font-size: 1.1rem; margin-bottom: 1rem;">Choisissez votre méthode de paiement</label>
                
                <div class="grid-2" style="gap: 1rem; margin-bottom: 1.5rem;">
                    <!-- Orange Money -->
                    <label style="border: 2px solid var(--border-soft); border-radius: 12px; padding: 1rem; cursor: pointer; display: flex; align-items: center; gap: 1rem; transition: 0.2s;" onmouseover="this.style.borderColor='#ff7900'" onmouseout="if(!this.control.checked) this.style.borderColor='var(--border-soft)'">
                        <input type="radio" name="payment_method" value="orange_money" required style="accent-color: #ff7900; width: 20px; height: 20px;" onchange="updateBorders(this)">
                        <div>
                            <div style="font-weight: 700; color: #ff7900;">Orange Money</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">Paiement mobile instantané</div>
                        </div>
                    </label>

                    <!-- MTN Mobile Money -->
                    <label style="border: 2px solid var(--border-soft); border-radius: 12px; padding: 1rem; cursor: pointer; display: flex; align-items: center; gap: 1rem; transition: 0.2s;" onmouseover="this.style.borderColor='#ffcc00'" onmouseout="if(!this.control.checked) this.style.borderColor='var(--border-soft)'">
                        <input type="radio" name="payment_method" value="mtn_money" required style="accent-color: #ffcc00; width: 20px; height: 20px;" onchange="updateBorders(this)">
                        <div>
                            <div style="font-weight: 700; color: #d4a900;">MTN MoMo</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">Paiement mobile instantané</div>
                        </div>
                    </label>
                </div>
                @error('payment_method') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="phone_number" class="form-label">Numéro de téléphone payeur</label>
                <input type="text" id="phone_number" name="phone_number" class="form-input" placeholder="Ex: 690000000" required>
                @error('phone_number') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-full" style="padding: 1.25rem; font-size: 1.1rem; justify-content: center; margin-top: 1rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                Valider le paiement
            </button>
        </form>
    </div>
</div>

<script>
    function updateBorders(selectedRadio) {
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            if(radio.checked) {
                radio.parentElement.style.borderColor = radio.value === 'orange_money' ? '#ff7900' : '#ffcc00';
            } else {
                radio.parentElement.style.borderColor = 'var(--border-soft)';
            }
        });
    }
</script>
@endsection
