<?php
namespace App\Livewire\Events;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination, AuthorizesRequests;

    public $title;
    public $description;
    public $start_time;
    public $end_time;
    public $location;
    public $event_id;
    public $eventToDelete = null;

    public function render()
    {
        return view('livewire.events.index', [
            'events' => Event::withCount('attendees')->paginate(10)
        ]);
    }

    public function create()
    {
        $this->authorize('create', Event::class);
        $this->resetInputFields();
        $this->dispatch('open-modal', 'event-modal');
    }

    private function resetInputFields()
    {
        $this->title = '';
        $this->description = '';
        $this->start_time = '';
        $this->end_time = '';
        $this->location = '';
        $this->event_id = '';
    }

    public function store()
    {
        $this->authorize('create', Event::class);

        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|string|max:255',
        ]);

        Event::create([
            'title' => $this->title,
            'description' => $this->description,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'location' => $this->location,
        ]);

        session()->flash('success', 'Event created successfully.');
        $this->dispatch('close-modal', 'event-modal');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $this->authorize('update', $event);

        $this->event_id = $id;
        $this->title = $event->title;
        $this->description = $event->description;
        // Format for HTML datetime-local input
        $this->start_time = Carbon::parse($event->start_time)->format('Y-m-d\TH:i');
        $this->end_time = Carbon::parse($event->end_time)->format('Y-m-d\TH:i');
        $this->location = $event->location;

        $this->dispatch('open-modal', 'event-modal');
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|string|max:255',
        ]);

        if ($this->event_id) {
            $event = Event::findOrFail($this->event_id);
            $this->authorize('update', $event);

            $event->update([
                'title' => $this->title,
                'description' => $this->description,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'location' => $this->location,
            ]);

            session()->flash('success', 'Event updated successfully.');
            $this->dispatch('close-modal', 'event-modal');
            $this->resetInputFields();
        }
    }

    public function confirmDelete($id)
    {
        $this->eventToDelete = $id;
        $this->dispatch('open-modal', 'delete-confirmation');
    }

    public function delete()
    {
        if ($this->eventToDelete) {
            $event = Event::findOrFail($this->eventToDelete);
            $this->authorize('delete', $event);

            $event->delete();
            session()->flash('success', 'Event deleted successfully.');
            $this->eventToDelete = null;
            $this->dispatch('close-modal', 'delete-confirmation');
        }
    }
}
