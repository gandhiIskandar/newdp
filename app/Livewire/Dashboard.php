<?php

namespace App\Livewire;

use App\Models\Task;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]

class Dashboard extends Component
{
    public $totalUsersToday;

    public $totalTransaksi;

    public $tasks;

    public $finishedTask = [];

    public $transactions;

    public function mount()
    {
        if (! privilegeViewDashboard()) {
            return abort(403, 'Akses Dilarang');
        }
    }

    #[On('transactionCreated')]
    public function render()
    {

        $this->getTransactionStats();
        $this->getTodoList();
        dd($this->tasks);

        return view('livewire.dashboard');
    }

    // public function getMemberStats()
    // {

    //         // Mendapatkan tanggal hari ini
    //         $today = Carbon::today();

    //         // Query untuk menghitung total pengguna yang dibuat hari ini
    //         $this->totalUsersToday = DB::table('members')
    //             ->whereDate('created_at', $today)
    //             ->count();

    // }

    public function getTransactionStats()
    {

        $totals = DB::table('transactions')
            ->whereDate('created_at', Carbon::today())
            ->selectRaw('
            SUM(CASE WHEN type_id = 1 THEN amount ELSE 0 END) AS total_wd,
            SUM(CASE WHEN type_id = 2 AND new = 0 THEN amount ELSE 0 END) AS total_re_depo,
            SUM(CASE WHEN type_id = 2 AND new = 1 THEN amount ELSE 0 END) AS total_new_depo
        ')
            ->first();

        $this->totalTransaksi = $totals;

        $this->transactions = Transaction::with(['member', 'type'])->whereDate('created_at', Carbon::today())->orderBy('created_at', 'desc')->get();

        //$this->totalTransaksi['totalWd'] = $totalWd;

    }

    public function getTodoList()
    {

        $user = session('user_data');

        $this->tasks = Task::where('user_id', $user->id)->where('is_completed', 0)->get();

    }

    public function updateTask()
    {

        Task::whereIn('id', $this->finishedTask)->update(['is_completed' => 1]);

    }
}
