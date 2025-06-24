<?php

namespace App\Policies;

use App\Models\Negotiation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NegotiationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Negotiation $negotiation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Negotiation $negotiation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Negotiation $negotiation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Negotiation $negotiation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Negotiation $negotiation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can manage the negotiation.
     */
    public function manage(User $user, Negotiation $negotiation): bool
    {
        // Hanya penjual dari negosiasi ini yang bisa mengelolanya
        return $user->id === $negotiation->seller_id;
    }
}
