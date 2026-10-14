<?php
namespace App\Livewire\Frontend;

use Livewire\Component;
use Lunar\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderDetail extends Component
{
    use AuthorizesRequests;

    public Order $order;

    public function mount(Order $order)
    {
        // Controllo di sicurezza: l'ordine deve appartenere all'utente loggato
        // (Verifica se usi user_id diretto o tramite il customer di Lunar)
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Accesso non autorizzato a questo ordine.');
        }

        $this->order = $order;
    }

    public function render()
    {
        // Carica le relazioni utili di Lunar (righe dell'ordine, indirizzi, spedizioni)
        $this->order->load(['lines', 'shippingAddress', 'billingAddress', 'transactions']);

        return view('livewire.frontend.order-detail');
    }
}