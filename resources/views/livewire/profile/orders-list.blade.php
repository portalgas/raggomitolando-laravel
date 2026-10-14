<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('user/order.list') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('user/order.list_info') }}
        </p>
    </header>
    
    @php
        $orders = auth()->user()->orders()->latest()->get();
    @endphp
            
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">I miei ordini</h1>

        @if($orders->isEmpty())
            <p class="text-gray-500">{{ __('user/order.no_results') }}</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-left text-sm font-semibold text-gray-600">
                            <th class="py-3 px-4 border-b">{{ __('user/order.table.order') }}</th>
                            <th class="py-3 px-4 border-b">{{ __('user/order.table.date') }}</th>
                            <th class="py-3 px-4 border-b">{{ __('user/order.table.total') }}</th>
                            <th class="py-3 px-4 border-b">{{ __('user/order.table.status') }}</th>
                            <th class="py-3 px-4 border-b text-right">{{ __('user/order.table.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700">
                        @foreach($orders as $order)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4 font-medium">
                                    {{ $order->reference ?? $order->id }}
                                </td>
                                <td class="py-3 px-4">
                                    {{ $order->placed_at ? $order->placed_at->format('d/m/Y H:i') : $order->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="py-3 px-4">
                                    {{-- Lunar memorizza i prezzi in centesimi, quindi solitamente si usa la formattazione o la proprietà formatted_total --}}
                                    {{ $order->total->formatted() }}
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <a href="{{ route('orders.show', $order->id) }}" class="text-indigo-600 hover:underline">
                                    {{ __('user/order.btn.view') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</section>