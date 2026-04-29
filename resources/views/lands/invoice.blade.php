@extends('layouts.terrainvente')

@section('title', 'Facture d\'achat')

@section('content')
<div class="page-wrap-sm" style="display: flex; justify-content: center; min-height: 70vh;">
    <div style="width: 100%; max-width: 600px;">
        @if(session('success'))
            <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="card" style="padding: 3rem 2rem; border-top: 8px solid var(--primary);">
            <div style="text-align: center; margin-bottom: 3rem;">
                <h1 style="font-size: 2.5rem; font-weight: 900; margin-bottom: 0.5rem; letter-spacing: 2px;">FACTURE</h1>
                <p style="color: var(--text-muted);">Reçu de Transaction Foncière</p>
            </div>

            <div style="display: flex; justify-content: space-between; margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid var(--border-soft);">
                <div>
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.25rem;">N° de Facture</p>
                    <p style="font-weight: 700; font-family: monospace; font-size: 1.1rem;">{{ session('invoice_id', 'TRX-' . strtoupper(uniqid())) }}</p>
                </div>
                <div style="text-align: right;">
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.25rem;">Date</p>
                    <p style="font-weight: 600;">{{ session('invoice_date', now()->format('d/m/Y H:i:s')) }}</p>
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.5rem;">Détails de l'acheteur</p>
                <p style="font-weight: 700; font-size: 1.2rem;">{{ Auth::user()->name }}</p>
                <p style="color: var(--text-muted);">{{ Auth::user()->email }}</p>
                <p style="color: var(--text-muted);">Tél : {{ session('invoice_phone', 'Non renseigné') }}</p>
            </div>

            <table style="width: 100%; border-collapse: collapse; margin-bottom: 2rem;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border-soft);">
                        <th style="text-align: left; padding: 1rem 0; color: var(--text-muted); font-size: 0.875rem;">Description</th>
                        <th style="text-align: right; padding: 1rem 0; color: var(--text-muted); font-size: 0.875rem;">Montant</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom: 1px solid var(--border-soft);">
                        <td style="padding: 1.5rem 0;">
                            <p style="font-weight: 700;">{{ $land->title }}</p>
                            <p style="font-size: 0.875rem; color: var(--text-muted);">{{ $land->location }}</p>
                        </td>
                        <td style="padding: 1.5rem 0; text-align: right; font-weight: 700;">
                            {{ number_format(session('invoice_price', $land->price_cfa), 0, ',', ' ') }} FCFA
                        </td>
                    </tr>
                </tbody>
            </table>

            <div style="background: var(--bg-body); padding: 1.5rem; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-weight: 600; color: var(--text-muted);">Total payé</span>
                <span style="font-size: 1.5rem; font-weight: 900; color: var(--primary);">
                    {{ number_format(session('invoice_price', $land->price_cfa), 0, ',', ' ') }} FCFA
                </span>
            </div>
            
            <div style="text-align: center; margin-top: 1rem;">
                <span style="font-size: 0.8rem; color: var(--text-muted); padding: 0.25rem 0.75rem; background: #e5e7eb; border-radius: 100px;">
                    Payé via {{ session('invoice_method') == 'orange_money' ? 'Orange Money' : (session('invoice_method') == 'mtn_money' ? 'MTN Mobile Money' : 'Mobile Money') }}
                </span>
            </div>

            <div style="text-align: center; margin-top: 3rem; display: flex; gap: 1rem; justify-content: center;">
                <button onclick="window.print()" class="btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                    Imprimer
                </button>
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    Retour au tableau de bord
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body { visibility: hidden; }
        .card { visibility: visible; position: absolute; left: 0; top: 0; width: 100%; border: none !important; box-shadow: none !important; }
        .btn, .back-link { display: none !important; }
    }
</style>
@endsection
