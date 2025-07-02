<?php

namespace App\Http\Livewire;

use App\Models\Schedule;
use App\Models\SchoolClass;
use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;

class Schedules extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $editMode = false;
    public $scheduleId;

    // Form fields
    public $school_class_id;
    public $subject_id;
    public $day;
    public $start_time;
    public $end_time;

    // Lists for dropdowns
    public $classes = [];
    public $subjects = [];
    public $days = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];

    protected $rules = [
        'school_class_id' => 'required|exists:school_classes,id',
        'subject_id' => 'required|exists:subjects,id',
        'day' => 'required|in:lundi,mardi,mercredi,jeudi,vendredi,samedi',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
    ];

    protected $messages = [
        'school_class_id.required' => 'La classe est requise',
        'school_class_id.exists' => 'La classe sélectionnée n\'existe pas',
        'subject_id.required' => 'La matière est requise',
        'subject_id.exists' => 'La matière sélectionnée n\'existe pas',
        'day.required' => 'Le jour est requis',
        'day.in' => 'Le jour sélectionné n\'est pas valide',
        'start_time.required' => 'L\'heure de début est requise',
        'start_time.date_format' => 'L\'heure de début doit être au format HH:MM',
        'end_time.required' => 'L\'heure de fin est requise',
        'end_time.date_format' => 'L\'heure de fin doit être au format HH:MM',
        'end_time.after' => 'L\'heure de fin doit être après l\'heure de début',
    ];

    public function mount()
    {
        $this->classes = SchoolClass::all();
        $this->subjects = Subject::all();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $schedules = Schedule::with(['schoolClass', 'subject'])
            ->whereHas('schoolClass', function($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('subject', function($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('day')
            ->orderBy('start_time')
            ->paginate(10);

        return view('livewire.schedules', [
            'schedules' => $schedules
        ]);
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['school_class_id', 'subject_id', 'day', 'start_time', 'end_time']);
        $this->editMode = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $this->editMode = true;
        $this->scheduleId = $id;
        $schedule = Schedule::find($id);
        $this->school_class_id = $schedule->school_class_id;
        $this->subject_id = $schedule->subject_id;
        $this->day = $schedule->day;
        $this->start_time = substr($schedule->start_time, 0, 5);
        $this->end_time = substr($schedule->end_time, 0, 5);
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            $schedule = Schedule::find($this->scheduleId);
            $schedule->update([
                'school_class_id' => $this->school_class_id,
                'subject_id' => $this->subject_id,
                'day' => $this->day,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
            ]);
            flash()->success('Emploi du temps mis à jour avec succès.');
        } else {
            Schedule::create([
                'school_class_id' => $this->school_class_id,
                'subject_id' => $this->subject_id,
                'day' => $this->day,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
            ]);
            flash()->success('Emploi du temps créé avec succès.');
        }

        $this->showModal = false;
        $this->reset(['school_class_id', 'subject_id', 'day', 'start_time', 'end_time']);
    }

    public function delete($id)
    {
        Schedule::find($id)->delete();
        flash()->success('Emploi du temps supprimé avec succès.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetValidation();
        $this->reset(['school_class_id', 'subject_id', 'day', 'start_time', 'end_time']);
    }
}
