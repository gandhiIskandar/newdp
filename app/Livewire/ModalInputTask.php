<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;

class ModalInputTask extends Component
{
    public $tasks;

    public $user_id;

    public $name;

    public $role;

    public $newTask;

    public function render()
    {
        return view('livewire.modal-input-task');
    }

    #[\Livewire\Attributes\On('showModalTask')]
    public function showModal($user)
    {
        $this->user_id = $user['id'];

        //data yang diterima dari Powergrid merupakan array jadi harus pakai []
        $this->name = $user['name'];
        $this->role = $user['role']['name'];

        $this->tasks = Task::where('user_id', $user['id'])->get();

        $this->dispatch('showModalTaskJS');
    }

    #[\Livewire\Attributes\On('deleteTask')]
    public function deleteTask($task_id)
    {

        $task = Task::find($task_id);

        if ($task == null) {

            flash('Terjadi Kesalahan', 'alert-danger');

            return null;
        }

        $task->delete();

        $this->tasks = Task::where('user_id', $this->user_id)->get();

        flash('Berhasil Hapus Task', 'alert-success');
    }

    #[\Livewire\Attributes\On('insertTask')] // terpaksa pakai dispatch karena wire submit error kacau!
    public function insertTask()
    {

        $task = Task::create([
            'name' => $this->newTask,
            'user_id' => $this->user_id,
        ]);

        $this->tasks->push($task);

        $this->newTask = '';

        flash('Berhasil Tambah Task', 'alert-success');
    }
}
