<?php
namespace App\Livewire;

use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

#[Layout('layouts.app')]
class Roles extends Component
{
    use WithPagination, AuthorizesRequests;

    public $name;
    public $description;
    public $role_id;
    public $roleToDelete = null;

    public function render()
    {
        return view('livewire.roles', [
            'roles' => Role::withCount('users')->paginate(10)
        ]);
    }

    public function create()
    {
        $this->authorize('create', Role::class);
        $this->resetInputFields();
        $this->dispatch('open-modal', 'role-modal');
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->role_id = '';
    }

    public function store()
    {
        $this->authorize('create', Role::class);

        $this->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'description' => 'nullable|string'
        ]);

        Role::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        session()->flash('success', 'Role created successfully.');
        $this->dispatch('close-modal', 'role-modal');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $this->authorize('update', $role);

        $this->role_id = $id;
        $this->name = $role->name;
        $this->description = $role->description;

        $this->dispatch('open-modal', 'role-modal');
    }

    public function update()
    {
        $role = Role::findOrFail($this->role_id);
        $this->authorize('update', $role);

        $this->validate([
            'name' => 'required|string|max:255|unique:roles,name,'.$this->role_id,
            'description' => 'nullable|string'
        ]);

        $role->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        session()->flash('success', 'Role updated successfully.');
        $this->dispatch('close-modal', 'role-modal');
        $this->resetInputFields();
    }

    public function confirmDelete($id)
    {
        $this->roleToDelete = $id;
        $this->dispatch('open-modal', 'delete-confirmation');
    }

    public function delete()
    {
        $role = Role::findOrFail($this->roleToDelete);
        $this->authorize('delete', $role);

        $role->delete();
        session()->flash('success', 'Role deleted successfully.');
        $this->roleToDelete = null;
        $this->dispatch('close-modal', 'delete-confirmation');
    }
}
