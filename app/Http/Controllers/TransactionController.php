<?php

namespace App\Http\Controllers;

use App\Models\Land;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Affiche la page de paiement simulé
     */
    public function checkout(Land $land)
    {
        if ($land->user_id === Auth::id()) {
            return back()->with('error', 'Vous ne pouvez pas acheter votre propre terrain.');
        }

        if ($land->status !== 'disponible') {
            return back()->with('error', 'Ce terrain n\'est plus disponible.');
        }

        return view('lands.checkout', compact('land'));
    }

    /**
     * Gère l'achat d'un terrain (Mutation de propriété et simulation paiement)
     */
    public function purchase(Request $request, Land $land)
    {
        $request->validate([
            'payment_method' => 'required|in:orange_money,mtn_money',
            'phone_number'   => 'required|string',
        ]);
        $buyer = Auth::user();

        // 1. Vérifications de sécurité
        if ($land->user_id === $buyer->id) {
            return back()->with('error', 'Vous possédez déjà ce terrain.');
        }

        if ($land->status !== 'disponible') {
            return back()->with('error', 'Ce terrain n\'est plus disponible.');
        }

        try {
            DB::beginTransaction();

            // 2. Logique de mutation (Transfert de user_id)
            $oldOwnerId = $land->user_id;
            
            $land->update([
                'user_id' => $buyer->id,
                'status' => 'vendu' // On le marque comme vendu par défaut
            ]);

            // Ici, on pourrait ajouter une ligne dans une table 'transactions' pour l'historique

            DB::commit();

            // Flash un message de succès et des données fantômes pour la facture
            session()->flash('success', 'Paiement de ' . number_format($land->price_cfa, 0, ',', ' ') . ' FCFA via ' . ($request->payment_method == 'orange_money' ? 'Orange Money' : 'MTN Mobile Money') . ' validé avec succès !');
            session()->flash('invoice_method', $request->payment_method);
            session()->flash('invoice_phone', $request->phone_number);
            session()->flash('invoice_id', 'TRX-' . strtoupper(uniqid()));
            session()->flash('invoice_date', now()->format('d/m/Y H:i:s'));
            session()->flash('invoice_price', $land->price_cfa);

            return redirect()->route('lands.invoice', $land);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'La transaction a échoué. Veuillez réessayer.');
        }
    }

    /**
     * Permet à un propriétaire de remettre son bien en vente
     */
    public function relist(Land $land)
    {
        if ($land->user_id !== Auth::id()) {
            abort(403);
        }

        $land->update(['status' => 'disponible']);

        return back()->with('success', 'Le terrain est à nouveau disponible à la vente.');
    }

    /**
     * Affiche la facture générée
     */
    public function invoice(Land $land)
    {
        // La facture n'est lisible que par l'acheteur et juste après l'achat (grâce à la session, ou en temps que proprio)
        if ($land->user_id !== Auth::id()) {
            abort(403);
        }

        return view('lands.invoice', compact('land'));
    }
}