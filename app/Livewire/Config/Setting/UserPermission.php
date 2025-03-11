<?php

namespace App\Livewire\Config\Setting;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use WireUi\Traits\WireUiActions;

class UserPermission extends Component
{
    use WireUiActions;
    public $name;
    public $role_id = '';
    public $search;
    // public $permission_name;



    public function createRole()
    {
        $this->validate([
            'name' => 'required|unique:roles',
        ]);
        Role::create([
            'name' => $this->name,
        ]);

        $this->dispatch('closeModal', 'newRoleModal');
        $this->reset('name');
        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Created',
            'description' => 'An role was successuflly added.'
        ]);
    }
    public function createPermission()
    {
        $this->validate([
            'name' => 'required|unique:permissions',
        ]);
        Permission::create([
            'name' => $this->name,
        ]);

        $this->dispatch('closeModal', 'newPermissionModal');
        $this->reset('name');
        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Created',
            'description' => 'An role was successuflly added.'
        ]);
    }

    // Confirm noti sent
    public function addAssignPermissionConfirm($permissionId)
    {
        $this->notification()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Add permission for this Role?',
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, Add',
                'method' => 'permissionToRole',
                'params' => $permissionId,
            ],
            'reject' => [
                'label' => 'No, cancel',
                'method' => 'onClose',
            ],

            'onDismiss' => [
                'method' => 'cancleConfirm',
                'params' => ['event' => 'onDismiss'],
            ],

        ]);
    }

    // Confirm noti sent
    public function removeAssignPermissionConfirm($permissionId)
    {
        $this->notification()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Remove this permission  for this role?',
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, revoke it',
                'method' => 'removePermissionToRole',
                'params' => $permissionId,
            ],
            'reject' => [
                'label' => 'No, cancel',
                'method' => 'cancleConfirm',
            ],
            'onDismiss' => [
                'method' => 'cancleConfirm',
                'params' => ['event' => 'onDismiss'],
            ],

        ]);
    }


    public function cancleConfirm()
    {
        $this->notification()->send([
            'icon' => 'info',
            'title' => 'Cancled!',
            'description' => 'You cancled role delete confirmation.'
        ]);
    }

    //permission give to a role
    public function permissionToRole($id)
    {
        $role = Role::find($this->role_id);
        $permission = Permission::find($id);
        $role->givePermissionTo($permission);
    }

    //revokepermisssion from a role
    public function removePermissionToRole($id)
    {
        $role = Role::find($this->role_id);
        $permission = Permission::find($id);
        $role->revokePermissionTo($permission);
    }

    #[Title('Role & Permission')]
    public function render()
    {
        $roleId = $this->role_id;
        if ($this->role_id) {
            $permissions_of_role = DB::table('permissions')
                ->leftJoin('role_has_permissions', function ($join) use ($roleId) {
                    $join->on('permissions.id', '=', 'role_has_permissions.permission_id')
                        ->where('role_has_permissions.role_id', '=', $roleId);
                })
                ->select(
                    'permissions.id as id',
                    'permissions.name as name',
                    DB::raw('CASE WHEN role_has_permissions.permission_id IS NOT NULL THEN TRUE ELSE FALSE END as status')
                )
                ->where('permissions.name', 'like', '%' . $this->search . '%')
                ->get();
        }

        return view('livewire.config.setting.user-permission', [
            'roles' => Role::all(),
            'permissions' => Permission::all(),
            'permissions_role' => $permissions_of_role ?? [],
        ]);
    }
}
