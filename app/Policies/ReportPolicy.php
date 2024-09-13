<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Auth\Access\Response;
use Psy\Util\Str;
use function Symfony\Component\Mime\Test\Constraint\toString;

class ReportPolicy
{
    public function before(User $user, string $ability): bool|null {

        if($user->roles()->getAdmin()->exists()) {
            return true;
        }
        return null;
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->roles()->getManager()->exists()) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Report $report): bool
    {
        if($user->roles()->getManager()->exists() && ($user->id == $report->user_id) && (Carbon::parse($report->created_at) >= Carbon::now()->subMonth())) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Report $report): bool
    {
        if($user->roles()->getManager()->exists() && ($user->id == $report->user_id) && (Carbon::parse($report->created_at) >= Carbon::now()->subMonth())) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Report $report): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Report $report): bool
    {
        return false;
    }
}
