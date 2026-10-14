<?php
namespace App\Livewire\Frontend;

use Livewire\Component;
use Lunar\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserDashboard extends Component
{
    use AuthorizesRequests;

    public function mount(Order $order)
    {
    }

    public function render()
    {
        return view('livewire.frontend.user-dashboard');
    }
}