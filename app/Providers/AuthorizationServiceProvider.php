<?php

namespace App\Providers;

use App\Models\Role;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthorizationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        try {
            // Remove Cache::remember and fetch roles directly
            $roles = Role::with('permissions')->get(['id', 'name']);
            $permissionsArray = [];
            foreach ($roles as $role) {
                foreach ($role->permissions as $permissions) {
                    // Construct permission key combining module_name and can
                    $permissionKey = "$permissions->module.$permissions->permission";
                    // Use permission name as the key
                    $permissionsArray[$permissions->name][$permissionKey][] = $role->id;
                }
            }

            // Every permission may have multiple roles assigned
            foreach ($permissionsArray as $permissionDetails) {
                foreach ($permissionDetails as $key => $roles) {
                    // Define a gate for each permission
                    Gate::define($key, static function ($user) use ($roles) {
                        // If the user is not authenticated, return false
                        if (!Auth::check()) {
                            return false;
                        }
                        // Remove Cache::remember and fetch user roles directly
                        $userRoles = $user->roles->pluck('id')->toArray();
                        return count(array_intersect($userRoles, $roles)) > 0;
                    });
                }
            }
        } catch (Exception $e) {
            Log::error('Error setting up authorization gates: ' . $e->getMessage());
        }
    }
}
