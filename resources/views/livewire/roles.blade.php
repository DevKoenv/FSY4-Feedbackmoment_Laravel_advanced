<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Roles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between mb-6">
                        <h2 class="text-2xl font-semibold">Manage Roles</h2>
                        <x-primary-button wire:click="create">
                            Create Role
                        </x-primary-button>
                    </div>

                    <div class="mt-8">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                                <thead>
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-2 pr-2 text-left text-sm font-semibold sm:pl-6">Name</th>
                                        <th scope="col"
                                            class="hidden px-3 py-3.5 text-left text-sm font-semibold sm:table-cell">
                                            Description</th>
                                        <th scope="col"
                                            class="hidden px-3 py-3.5 text-left text-sm font-semibold md:table-cell">
                                            Users Count</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td
                                                class="w-full max-w-0 py-4 pl-2 pr-2 text-sm font-medium sm:w-auto sm:max-w-none sm:pl-6">
                                                <div class="truncate hover:text-clip" title="{{ $role->name }}">
                                                    {{ $role->name }}
                                                </div>
                                                <dl class="font-normal sm:hidden">
                                                    <dt class="sr-only">Description</dt>
                                                    <dd class="mt-1 truncate text-gray-500">
                                                        {{ $role->description }}</dd>
                                                    <dt class="sr-only">Users Count</dt>
                                                    <dd class="mt-1 truncate text-gray-500">
                                                        {{ $role->users_count }}</dd>
                                                </dl>
                                            </td>
                                            <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell">
                                                {{ $role->description }}</td>
                                            <td class="hidden px-3 py-4 text-sm text-gray-500 md:table-cell">
                                                {{ $role->users_count }}</td>
                                            <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                <div class="flex justify-end space-x-2">
                                                    <button wire:click="edit({{ $role->id }})"
                                                        x-on:click="$dispatch('open-modal', 'role-modal')"
                                                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button wire:click="confirmDelete({{ $role->id }})"
                                                        x-on:click="$dispatch('open-modal', 'delete-confirmation')"
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $roles->links('vendor.pagination.tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Role Modal -->
    <x-modal name="role-modal">
        <form wire:submit.prevent="{{ $role_id ? 'update' : 'store' }}" class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ $role_id ? 'Edit Role' : 'Create Role' }}
            </h2>

            <div class="mt-6">
                <x-input-label for="name" value="Name" />
                <x-text-input wire:model="name" id="name" type="text" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-input-label for="description" value="Description" />
                <textarea wire:model="description" id="description"
                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                </textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Cancel
                </x-secondary-button>

                <x-primary-button class="ml-3">
                    {{ $role_id ? 'Update' : 'Create' }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Delete Confirmation Modal -->
    <x-modal name="delete-confirmation">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Delete Role') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Are you sure you want to delete this role? This action cannot be undone.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="delete" x-on:click="$dispatch('close')">
                    {{ __('Delete Role') }}
                </x-danger-button>
            </div>
        </div>
    </x-modal>
</div>
