<div class="max-w-5xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Dettaglio Ordine #{{ $order->reference ?? $order->id }}
            </h1>
            <p class="text-sm text-gray-500">
                Effettuato il {{ $order->placed_at ? $order->placed_at->format('d/m/Y H:i') : $order->created_at->format('d/m/Y H:i') }}
            </p>
        </div>
        <div>
            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 uppercase">
                {{ $order->status }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Indirizzo di Spedizione -->
        @if($order->shippingAddress)
            <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                <h3 class="font-semibold text-gray-700 mb-2">Indirizzo di Spedizione</h3>
                <p class="text-sm text-gray-600">{{ $order->shippingAddress->first_name }} {{ $order->shippingAddress->last_name }}</p>
                <p class="text-sm text-gray-600">{{ $order->shippingAddress->line_1 }}</p>
                @if($order->shippingAddress->line_2)<p class="text-sm text-gray-600">{{ $order->shippingAddress->line_2 }}</p>@endif
                <p class="text-sm text-gray-600">{{ $order->shippingAddress->postcode }} {{ $order->shippingAddress->city }} @if(!empty($order->shippingAddress->state))({{ $order->shippingAddress->state }})@endif</p>
            </div>
        @endif

        <!-- Indirizzo di Fatturazione -->
        @if($order->billingAddress)
            <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                <h3 class="font-semibold text-gray-700 mb-2">Indirizzo di Fatturazione</h3>
                <p class="text-sm text-gray-600">{{ $order->billingAddress->first_name }} {{ $order->billingAddress->last_name }}</p>
                <p class="text-sm text-gray-600">{{ $order->billingAddress->line_1 }}</p>
                @if($order->billingAddress->line_2)<p class="text-sm text-gray-600">{{ $order->billingAddress->line_2 }}</p>@endif
                <p class="text-sm text-gray-600">{{ $order->billingAddress->postcode }} {{ $order->billingAddress->city }} @if(!empty($order->billingAddress->state))({{ $order->billingAddress->state }})@endif</p>
            </div>
        @endif

        <!-- Riepilogo Economico -->
        <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
            <h3 class="font-semibold text-gray-700 mb-2">Riepilogo</h3>
            <div class="flex justify-between text-sm text-gray-600 mb-1">
                <span>Subtotale:</span>
                <span>{{ $order->sub_total?->formatted() }}</span>
            </div>
            <div class="flex justify-between text-sm text-gray-600 mb-1">
                <span>Spedizione:</span>
                <span>{{ $order->shipping_total?->formatted() }}</span>
            </div>
            <div class="flex justify-between text-sm text-gray-600 mb-1">
                <span>Tasse:</span>
                <span>{{ $order->tax_total?->formatted() }}</span>
            </div>
            <div class="border-t pt-2 mt-2 flex justify-between font-bold text-gray-900">
                <span>Totale:</span>
                <span>{{ $order->total?->formatted() }}</span>
            </div>
        </div>
    </div>

    <!-- Elenco Prodotti dell'Ordine -->
    <div class="bg-white shadow rounded-lg overflow-hidden border border-gray-200">
        <h3 class="px-6 py-4 font-semibold text-gray-700 border-b bg-gray-50">Articoli Ordinati</h3>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3">Prodotto</th>
                    <th class="px-6 py-3 text-center">Quantità</th>
                    <th class="px-6 py-3 text-right">Prezzo Unitario</th>
                    <th class="px-6 py-3 text-right">Totale</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                @foreach($order->lines as $line)
                    <tr>
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $line->description }}
                            @if($line->option)
                                <span class="block text-xs text-gray-500">{{ $line->option }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">{{ $line->quantity }}</td>
                        <td class="px-6 py-4 text-right">{{ $line->unit_price?->formatted() }}</td>
                        <td class="px-6 py-4 text-right font-semibold">{{ $line->total?->formatted() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pulsante Indietro -->
    <div class="mt-6">
        <a href="{{ route('profile') }}" class="text-indigo-600 hover:underline text-sm font-medium">
            &larr; Torna alla lista ordini
        </a>
    </div>
</div>