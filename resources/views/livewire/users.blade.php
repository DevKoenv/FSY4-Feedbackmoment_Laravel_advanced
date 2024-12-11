<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between mb-6">
                        <h2 class="text-2xl font-semibold">Manage Users</h2>
                        @can('create', 'App\\Models\User')
                            <x-primary-button wire:click="create">
                                Create User
                            </x-primary-button>
                        @endcan
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
                                            Email</th>
                                        <th scope="col"
                                            class="hidden px-3 py-3.5 text-left text-sm font-semibold md:table-cell">
                                            Roles</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($users as $user)
                                        <tr>
                                            <td
                                                class="w-full max-w-0 py-4 pl-2 pr-2 text-sm font-medium sm:w-auto sm:max-w-none sm:pl-6">
                                                <div class="truncate hover:text-clip" title="{{ $user->name }}">
                                                    {{ $user->name }}
                                                </div>
                                                <dl class="font-normal sm:hidden">
                                                    <dt class="sr-only">Email</dt>
                                                    <dd class="mt-1 truncate text-gray-500">
                                                        {{ $user->email }}</dd>
                                                    <dt class="sr-only">Roles</dt>
                                                    <dd class="mt-1 truncate text-gray-500">
                                                        {{ $user->roles->pluck('name')->join(', ') }}</dd>
                                                </dl>
                                            </td>
                                            <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell">
                                                {{ $user->email }}</td>
                                            <td class="hidden px-3 py-4 text-sm text-gray-500 md:table-cell">
                                                {{ $user->roles->pluck('name')->join(', ') }}</td>
                                            <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                <div class="flex justify-end space-x-2">
                                                    @can('update', $user)
                                                        <button wire:click="edit({{ $user->id }})"
                                                            x-on:click="$dispatch('open-modal', 'user-modal')"
                                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    @endcan
                                                    @can('delete', $user)
                                                        <button wire:click="confirmDelete({{ $user->id }})"
                                                            x-on:click="$dispatch('open-modal', 'delete-confirmation')"
                                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $users->links('vendor.pagination.tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Modal -->
    <x-modal name="user-modal">
        <form wire:submit.prevent="{{ $user_id ? 'update' : 'store' }}" class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ $user_id ? 'Edit User' : 'Create User' }}
            </h2>

            <div class="mt-6">
                <x-input-label for="name" value="Name" />
                <x-text-input wire:model="name" id="name" type="text" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-input-label for="email" value="Email" />
                <x-text-input wire:model="email" id="email" type="email" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-input-label for="password" value="{{ $user_id ? 'New Password (leave blank to keep current)' : 'Password' }}" />
                <x-text-input wire:model="password" id="password" type="password" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-input-label for="roles" value="Roles" />
                <div class="mt-2 space-y-2">
                    @foreach($roles as $role)
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="selectedRoles" value="{{ $role->id }}"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="ml-2">{{ $role->name }}</span>
                        </label>
                    @endforeach
                </div>
                <x-input-error :messages="$errors->get('selectedRoles')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Cancel
                </x-secondary-button>

                <x-primary-button class="ml-3">
                    {{ $user_id ? 'Update' : 'Create' }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Delete Confirmation Modal -->
    <x-modal name="delete-confirmation">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Delete User') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Are you sure you want to delete this user? This action cannot be undone.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="delete" x-on:click="$dispatch('close')">
                    {{ __('Delete User') }}
                </x-danger-button>
            </div>
        </div>
    </x-modal>
</div>
