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

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3">Email</th>
                                    <th scope="col" class="px-6 py-3 w-fit" align="right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendees as $attendee)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-6 py-4">{{ $attendee->name }}</td>
                                        <td class="px-6 py-4">{{ $attendee->email }}</td>
                                        <td class="px-6 py-4" align="right">
                                            <x-danger-button wire:click="confirmDelete({{ $attendee->id }})"
                                                x-on:click="$dispatch('open-modal', 'delete-confirmation')">
                                                Remove
                                            </x-danger-button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
