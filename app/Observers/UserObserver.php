<?php
/**
 * Created by PhpStorm.
 * Handle some event for User model
 * Events: retrieved, creating, created, updating, updated, saving, saved, deleting, deleted, restoring, restore
 * User: trinhnv
 * Date: 25/07/2018
 * Time: 15:29
 */

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle to the user "creating" event.
     *
     * @param  \App\Models\User $user
     * @return void
     */
    public function creating(User $user)
    {
        $user->name = strtoupper($user->name);
    }

    /**
     * Handle to the user "created" event.
     *
     * @param  \App\Models\User $user
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\Models\User $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\Models\User $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }
}
