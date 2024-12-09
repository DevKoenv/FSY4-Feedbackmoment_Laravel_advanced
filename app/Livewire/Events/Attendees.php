<?php

namespace App\Livewire\Events;

use App\Models\Attendee;
use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

#[Layout('layouts.app')]
class Attendees extends Component
{
    use WithPagination;

    public Event $event;
    public $name;
    public $email;
    public $attendee_id;
    public $attendeeToDelete = null;
    public $isEditing = false;

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function render()
    {
        return view('livewire.events.attendees', [
            'attendees' => $this->event->attendees()->paginate(10)
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->dispatch('open-modal', 'attendee-modal');
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->attendee_id = '';
        $this->isEditing = false;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $this->event->attendees()->create([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        session()->flash('success', 'Attendee created successfully.');
        $this->dispatch('close-modal', 'attendee-modal');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $attendee = $this->event->attendees()->findOrFail($id);
        $this->attendee_id = $id;
        $this->name = $attendee->name;
        $this->email = $attendee->email;
        $this->isEditing = true;

        $this->dispatch('open-modal', 'attendee-modal');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        if ($this->attendee_id) {
            $attendee = $this->event->attendees()->findOrFail($this->attendee_id);
            $attendee->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);

            session()->flash('success', 'Attendee updated successfully.');
            $this->dispatch('close-modal', 'attendee-modal');
            $this->resetInputFields();
        }
    }

    public function confirmDelete($id)
    {
        $this->attendeeToDelete = $id;
        $this->dispatch('open-modal', 'delete-confirmation');
    }

    public function delete()
    {
        if ($this->attendeeToDelete) {
            Attendee::find($this->attendeeToDelete)->delete();
            session()->flash('success', 'Attendee deleted successfully.');
            $this->attendeeToDelete = null;
            $this->dispatch('close-modal', 'delete-confirmation');
        }
    }
}
