<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between mb-6">
                        <h2 class="text-2xl font-semibold">Manage Events</h2>
                        <x-primary-button wire:click="create" x-on:click="$dispatch('open-modal', 'event-modal')">
                            Create Event
                        </x-primary-button>
                    </div>

                    <div class="mt-8 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle">
                                <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold">Title</th>
                                            <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold sm:table-cell">Start Time</th>
                                            <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold md:table-cell">Duration</th>
                                            <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold lg:table-cell">Location</th>
                                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($events as $event)
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm">
                                                <div class="font-medium">{{ $event->title }}</div>
                                                <!-- Mobile-only content -->
                                                <div class="mt-1 sm:hidden">
                                                    <div class="text-gray-500">{{ $event->start_time->format('Y-m-d H:i') }}</div>
                                                    <div class="text-gray-500">{{ $event->location }}</div>
                                                </div>
                                            </td>
                                            <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell">
                                                {{ $event->start_time->format('Y-m-d H:i') }}
                                            </td>
                                            <td class="hidden px-3 py-4 text-sm text-gray-500 md:table-cell">
                                                {{ $event->start_time->diffForHumans($event->end_time, true) }}
                                            </td>
                                            <td class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell">
                                                {{ $event->location }}
                                            </td>
                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                <button wire:click="edit({{ $event->id }})"
                                                    x-on:click="$dispatch('open-modal', 'event-modal')"
                                                    class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                    <i class="fas fa-edit"></i>
                                                    <span class="sr-only">Edit event</span>
                                                </button>
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
        </div>
    </div>

    <!-- Modal outside the card -->
    <x-modal name="event-modal">
        <form wire:submit.prevent="{{ $event_id ? 'update' : 'store' }}" class="p-6">
            <h2 class="text-lg font-medium text-gray-800 dark:text-gray-200">
                {{ $event_id ? 'Edit Event' : 'Create Event' }}
            </h2>

            <div class="mt-6">
                <x-input-label for="title" value="Title" />
                <x-text-input wire:model="title" id="title" class="block mt-1 w-full" type="text" />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="description" value="Description" />
                <textarea wire:model="description" id="description"
                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                </textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="start_time" value="Start Time" />
                <x-text-input wire:model="start_time" id="start_time" class="block mt-1 w-full" type="datetime-local" />
                <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="end_time" value="End Time" />
                <x-text-input wire:model="end_time" id="end_time" class="block mt-1 w-full" type="datetime-local" />
                <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="location" value="Location" />
                <x-text-input wire:model="location" id="location" class="block mt-1 w-full" type="text" />
                <x-input-error :messages="$errors->get('location')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Cancel
                </x-secondary-button>

                <x-primary-button class="ml-3">
                    {{ $event_id ? 'Update' : 'Create' }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Add this right after your event-modal -->
    <x-modal name="delete-confirmation">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-800 dark:text-gray-200">
                {{ __('Delete Event') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Are you sure you want to delete this event? This action cannot be undone.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" wire:click="delete" x-on:click="$dispatch('close')">
                    {{ __('Delete Event') }}
                </x-danger-button>
            </div>
        </div>
    </x-modal>
</div>
