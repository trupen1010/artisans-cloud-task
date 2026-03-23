<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserAccressControlRequest;
use App\Models\Permission;
use App\Models\Role;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class UserAccessController extends Controller
{
    /**
     * Constructor to apply middleware for permission checks.
     */
    public function __construct()
    {
        $this->middleware('CheckPermissionsMiddleware:rolePermission,view')->only(['index', 'datatable']);
        $this->middleware('CheckPermissionsMiddleware:rolePermission,add')->only(['create', 'store']);
        $this->middleware('CheckPermissionsMiddleware:rolePermission,edit')->only(['edit', 'update']);
        $this->middleware('CheckPermissionsMiddleware:rolePermission,delete')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.user-access-controll.index');
    }

    /**
     * Get the data for DataTables.
     *
     * @throws Exception
     */
    public function datatable(): JsonResponse
    {
        return DataTables::of(Role::query())
            ->addColumn('action', function ($role_permission) {
                return view('admin.user-access-controll.action', compact('role_permission'))->render();
            })->escapeColumns(['*'])->make();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.user-access-controll.create')->with('permissions', self::getPermissions());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws Exception|Throwable
     */
    public function store(UserAccressControlRequest $request): mixed
    {
        try {
            DB::beginTransaction();
            $role = Role::create(['name' => $request->name]);
            $role->permissions()->attach($request->permission);
            DB::commit();

            Cache::forget('permissions');

            return $this->viewResponseHandler('success', "User Access Controll $this->add_msg", 'admin.user.access.control.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('User Access Control creation failed: '.$e->getMessage());

            return $this->viewResponseHandler('fail', "User Access Controll $this->error_msg", 'admin.user.access.control.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @return void
     *
     * @throws Exception
     */
    public function show(Role $role) {}

    /**
     * Show the form for editing the specified resource.
     *
     * @throws Exception
     */
    public function edit(int $id): View
    {
        $role = Role::find($id);

        return view('admin.user-access-controll.edit')->with(['permissions' => self::getPermissions(), 'permissionIds' => $role->permissions()->pluck('id')->toArray(), 'role' => $role]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws Exception|Throwable
     */
    public function update(UserAccressControlRequest $request, int $id): mixed
    {
        try {
            DB::beginTransaction();
            $role = Role::find($id);
            $role->update(['name' => $request->name]);
            $role->permissions()->sync($request->permission);
            DB::commit();

            Cache::forget('permissions');

            return $this->viewResponseHandler('success', "User Access Controll $this->update_msg", 'admin.user.access.control.index');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('User Access Control update failed: '.$e->getMessage());

            return $this->viewResponseHandler('fail', "User Access Controll $this->error_msg", 'admin.user.access.control.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws Exception
     */
    public function destroy(int $id): mixed
    {
        try {
            Role::destroy($id);
            Cache::forget('permissions');

            return $this->viewResponseHandler('success', "User Access Control $this->delete_msg", 'admin.user.access.control.index');
        } catch (Exception $e) {
            Log::error('User Access Control deletion failed: '.$e->getMessage());

            return $this->viewResponseHandler('fail', "User Access Control $this->error_msg", 'admin.user.access.control.index');
        }
    }

    /**
     * Get permissions grouped by module.
     */
    private function getPermissions(): array
    {
        $permissionsData = Permission::get();
        $permissions = [];
        foreach ($permissionsData as $permission) {
            $permissions[$permission->module_display_name][$permission->id] = $permission->permission_display_name;
        }

        return $permissions;
    }
}
