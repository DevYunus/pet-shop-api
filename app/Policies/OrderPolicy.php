<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function before(User $user)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    public function update(User $user, Order $order)
    {
        return $user->id === $order->user_id;
    }

    public function show(User $user, Order $order)
    {
        return $user->id === $order->user_id;
    }

    public function destroy(User $user, Order $order)
    {
        return $user->id === $order->user_id;
    }
}
