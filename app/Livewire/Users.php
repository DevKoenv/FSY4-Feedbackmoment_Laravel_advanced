<?php
namespace App\Livewire;

use App\Models\User;
use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

#[Layout('layouts.app')]
class Users extends Component
{
    use WithPagination, AuthorizesRequests;

    public $name;
    public $email;
    public $password;
    public $user_id;
    public $userToDelete = null;
    public $selectedRoles = [];

    public function render()
    {
        return view('livewire.users', [
            'users' => User::with('roles')->paginate(10),
            'roles' => Role::all()
        ]);
    }

    public function create()
    {
        $this->authorize('create', User::class);
        $this->resetInputFields();
        $this->dispatch('open-modal', 'user-modal');
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->user_id = '';
        $this->selectedRoles = [];
    }

    public function store()
    {
        $this->authorize('create', User::class);

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'selectedRoles' => 'array'
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $user->roles()->sync($this->selectedRoles);

        session()->flash('success', 'User created successfully.');
        $this->dispatch('close-modal', 'user-modal');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->selectedRoles = $user->roles->pluck('id')->toArray();

        $this->dispatch('open-modal', 'user-modal');
    }

    public function update()
    {
        $user = User::findOrFail($this->user_id);
        $this->authorize('update', $user);

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$this->user_id,
            'password' => 'nullable|min:8',
            'selectedRoles' => 'array'
        ]);

        $userData = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if ($this->password) {
            $userData['password'] = Hash::make($this->password);
        }

        $user->update($userData);
        $user->roles()->sync($this->selectedRoles);

        session()->flash('success', 'User updated successfully.');
        $this->dispatch('close-modal', 'user-modal');
        $this->resetInputFields();
    }

    public function confirmDelete($id)
    {
        $this->userToDelete = $id;
        $this->dispatch('open-modal', 'delete-confirmation');
    }

    public function delete()
    {
        $user = User::findOrFail($this->userToDelete);
        $this->authorize('delete', $user);

        $user->delete();
        session()->flash('success', 'User deleted successfully.');
        $this->userToDelete = null;
        $this->dispatch('close-modal', 'delete-confirmation');
    }
}
