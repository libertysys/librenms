<?php

namespace App\Policies;

use App\Facades\Permissions;
use App\Models\User;
use App\Models\Device;
use Illuminate\Auth\Access\HandlesAuthorization;

class DevicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any devices.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasGlobalRead();
    }

    /**
     * Determine whether the user can view the device.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Device $device
     * @return mixed
     */
    public function view(User $user, Device $device)
    {
        return Permissions::canAccessDevice($device, $user);
    }

    /**
     * Determine whether the user can create devices.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasGlobalAdmin();
    }

    /**
     * Determine whether the user can update the device.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Device $device
     * @return mixed
     */
    public function update(User $user, Device $device)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the device.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Device $device
     * @return mixed
     */
    public function delete(User $user, Device $device)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the device.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Device $device
     * @return mixed
     */
    public function restore(User $user, Device $device)
    {
        return $user->hasGlobalAdmin();
    }

    /**
     * Determine whether the user can permanently delete the device.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Device $device
     * @return mixed
     */
    public function forceDelete(User $user, Device $device)
    {
        return $user->isAdmin();
    }
}
