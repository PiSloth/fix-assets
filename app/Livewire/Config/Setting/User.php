<?php

namespace App\Livewire\Config\Setting;

use App\Models\Branch;
use App\Models\User as ModelsUser;
use App\Models\UserBranch;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use WireUi\Traits\WireUiActions;

class User extends Component
{
    use WireUiActions;


    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    protected $pw_check;
    public $pw_message;
    public $branch_id = '';

    public $user_id;
    public $initialize_userId;
    public $role_id = '';

    // public function mount()
    // {
    //     $pw = Hash::make('0nlineS@leTWA');
    //     dd($pw);
    // }

    public function create()
    {
        $validated = $this->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);

        if ($this->pw_check == true) {
            $this->dialog()->show([
                'icon' => 'error',
                'title' => 'Confirmed Password need',
                'description' => 'Password confirmation must be the same.'
            ]);
            return;
        }

        $validated['password'] = Hash::make($validated['password']);

        // $existEmail = ModelsUser::whereEmail($validated['email'])->first();

        // if ($existEmail) {
        //     $this->dialog()->show([
        //         'icon' => 'error',
        //         'title' => 'Duplicate Email',
        //         'description' => 'This email address is used in another user.'
        //     ]);
        //     return;
        // }

        ModelsUser::create($validated);
        $this->reset('name', 'email', 'password', 'password_confirmation');
    }

    public function updatedPasswordConfirmation($value)
    {
        if ($this->password == $value) {
            $this->pw_check = true;
            $this->reset('pw_message');
        } else {
            $this->pw_message = "Password must be the same with above";
        }
    }

    public function selectUser($id)
    {
        $this->user_id = $id;
        $this->dispatch('openModal', 'assignBranchModal');
    }

    // Confirm noti sent
    public function removeAssignRoleConfirm($roleId)
    {
        $this->notification()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Remove this role item for this user?',
            'icon' => 'question',
            'accept' => [
                'label' => 'Yes, remove it',
                'method' => 'revokeRole',
                'params' => $roleId,
            ],
            'reject' => [
                'label' => 'No, cancel',
                'method' => 'onClose',
            ],

            'onClose' => [
                'method' => 'cancleConfirm',
                'params' => 'onClose',
            ],
            'onDismiss' => [
                'method' => 'onClose',
                'params' => ['event' => 'onDismiss'],
            ],
            'onTimeout' => [
                'method' => 'onClose',
                'params' => ['onTimeout', 'more value'],
            ],
        ]);
    }

    public function onClose()
    {
        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Closed Confirmation!',
            'description' => 'Throwed out confirm notification'
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

    // Asign branch to a user
    public function assignBranch()
    {
        $validated = $this->validate([
            'user_id' => 'required',
            'branch_id' => 'required'
        ]);

        $result = UserBranch::whereUserId($validated['user_id'])->first();

        if ($result) {
            $result->update([
                'branch_id' => $validated['branch_id']
            ]);
        } else {
            UserBranch::create($validated);
        }


        $this->reset('user_id', 'branch_id');
        $this->dispatch('closeModal', 'assignModal');
        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Updated',
            'description' => 'This user was created in a new branch'
        ]);
    }

    public function initializeUserData($id)
    {
        $user = ModelsUser::find($id);
        // dd($user->id);
        $this->initialize_userId = $user->id;

        $result = $user->roles;
        // dd($result);
        $this->dispatch('openModal', 'roleModal');
    }

    public function assignRole()
    {
        $this->validate([
            'role_id' => 'required',
        ]);

        $user = ModelsUser::find($this->initialize_userId);
        $role = Role::find($this->role_id);
        // dd($role);s

        if ($user->hasRole($role)) {
            $this->notification()->send([
                'icon' => 'info',
                'title' => 'Exist!',
                'description' => 'Role has been added already!'
            ]);
            $this->reset('role_id');
            return;
        } else {
            $user->assignRole($role);
        }
    }

    public function revokeRole($roleId)
    {
        $role = Role::find($roleId);
        $user = ModelsUser::find($this->initialize_userId);

        $user->removeRole($role);
    }

    #[Title('User Control')]

    public function render()
    {
        $users = ModelsUser::all();
        return view('livewire.config.setting.user', [
            'users' => $users,
            'branches' => Branch::all(),
            'roles' => Role::all(),

            'user_data' => ModelsUser::find($this->initialize_userId),
        ]);
    }
}
