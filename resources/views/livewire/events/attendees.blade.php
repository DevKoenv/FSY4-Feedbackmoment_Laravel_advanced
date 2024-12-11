<div>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Attendees for: ') }} {{ $event->title }}
            </h2>
            <x-secondary-button href="{{ route('events') }}" wire:navigate>
                Back to Events
            </x-secondary-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between mb-6">
                        <h2 class="text-2xl font-semibold">Manage Attendees</h2>
                        <x-primary-button wire:click="$dispatch('open-modal', 'attendee-modal')">
                            Add Attendee
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
                                            Email</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($attendees as $attendee)
                                        <tr>
                                            <td
                                                class="w-full max-w-0 py-4 pl-2 pr-2 text-sm font-medium sm:w-auto sm:max-w-none sm:pl-6">
                                                <div class="truncate hover:text-clip" title="{{ $attendee->name }}">
                                                    {{ $attendee->name }}</div>
                                                <dl class="font-normal sm:hidden">
                                                    <dt class="sr-only">Email</dt>
                                                    <dd class="mt-1 truncate text-gray-500">{{ $attendee->email }}</dd>
                                                </dl>
                                            </td>
                                            <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell">
                                                {{ $attendee->email }}</td>
                                            <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                <div class="flex justify-end space-x-2">
                                                    <button wire:click="confirmDelete({{ $attendee->id }})"
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
                            {{ $attendees->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Attendee Modal -->
    <x-modal name="attendee-modal">
        <form wire:submit.prevent="store" class="p-6">
            <h2 class="text-lg font-medium text-gray-800 dark:text-gray-200">
                Add New Attendee
            </h2>

            <div class="mt-6">
                <x-input-label for="name" value="Name" />
                <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="email" value="Email" />
                <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Cancel
                </x-secondary-button>

                <x-primary-button class="ml-3">
                    Add Attendee
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Delete Confirmation Modal -->
    <x-modal name="delete-confirmation">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-800 dark:text-gray-200">
                {{ __('Remove Attendee') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Are you sure you want to remove this attendee? This action cannot be undone.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="delete" x-on:click="$dispatch('close')">
                    {{ __('Remove Attendee') }}
                </x-danger-button>
            </div>
        </div>
    </x-modal>
</div>
