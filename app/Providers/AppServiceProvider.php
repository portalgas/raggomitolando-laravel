<?php

namespace App\Providers;

use App\Modifiers\ShippingModifier;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Lunar\Admin\Support\Facades\LunarPanel;
use Lunar\Base\ShippingModifiers;
use Lunar\Shipping\ShippingPlugin;
use Livewire\Volt\Volt;
use Lunar\Models\Customer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        LunarPanel::panel(
            fn ($panel) => $panel->plugins([
                new ShippingPlugin,
            ])
        )
            ->register();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(ShippingModifiers $shippingModifiers): void
    {
        Volt::mount([
            resource_path('views/livewire'),
        ]);
        
        $shippingModifiers->add(
            ShippingModifier::class
        );

        \Lunar\Facades\ModelManifest::replace(
            \Lunar\Models\Contracts\Product::class,
            \App\Models\Product::class,
            // \App\Models\CustomProduct::class,
        );

        // Ascolta l'evento di login di Laravel
        Event::listen(Login::class, function (Login $event) {
            $user = $event->user;

            // 1. Verifica se l'utente ha già un Customer collegato
            $customer = method_exists($user, 'customers') 
                        ? $user->customers()->first() 
                        : null;

            // 2. Se non esiste, crealo al volo e legalo all'utente
            if (!$customer) {
                $nameParts = explode(' ', $user->name, 2);

                $customer = Customer::create([
                    'first_name' => $nameParts[0] ?? $user->name,
                    'last_name' => $nameParts[1] ?? '',
                ]);

                // Associa l'utente al customer tramite la relazione di Lunar
                if (method_exists($user, 'customers')) {
                    $user->customers()->attach($customer->id);
                }
            }
        });        
    }
}
