<?php

namespace App\Livewire;

use App\Livewire\Forms\ExpForm;
use App\Models\Account;
use App\Models\Website;
use App\Models\Currency;
use App\Models\Expenditure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalInputExp extends Component
{
    public ExpForm $form;

    public $edit;

    public $websites;

    public $selectedWebsite;

    public $expenditure;

    public $accounts=[]; // untuk pilih rekening

    public $currencies; // untuk pilih rekening

    public function mount()
    {
        $userData = session('user_data');

        $this->currencies = Currency::all();

        if($userData->role->name == 'Super Admin'){

            $this->websites= Website::whereNotIn('id',[6])->get();

        }else{
            $this->websites= Website::whereNotIn('id',[5,6])->get();

        }
        
       
        //$this->accounts = Account::with('bank')->get();
    }

    public function render()
    {
        if($this->selectedWebsite != ''){

            $this->accounts = Account::with('bank')->where('website_id',$this->selectedWebsite)->get();

        }

        return view('livewire.modal-input-exp');
    }

    public function proceedExp()
    {
        $this->form->amount = str_replace('.', '', $this->form->amount);

        if (! $this->edit) {

            $this->insertExp();
        } else {
            $this->updateExp();
        }
    }

    public function insertExp()
    {

        $expenditure = $this->form->create();

        $expenditure->date = Carbon::parse($expenditure->created_at)->translatedFormat('d F Y');

        $this->dispatch('expCreated', cashbook: $expenditure);
        $this->dispatch('reloadPowerGridExp');
    }

    #[\Livewire\Attributes\On('showModalNonEditStateExp')]
    public function showModalNonEditState()
    {

        

        $this->form->reset();

        $this->edit = false;

        $this->dispatch('showModalExpJS');
    }

    #[\Livewire\Attributes\On('removeConfirmCashBook')]
    public function removeConfirm($cashbook_id)
    {

        $this->dispatch('removeConfirmCashBookJS', cashbook_id: $cashbook_id);
    }

    //fungsi inisiasi data member untuk edit transaksi
    #[\Livewire\Attributes\On('showModalExpEdit')]
    public function showModalInputEditState($expenditure_id)
    {

        $this->edit = true; //aktifkan state edit

        $this->expenditure = Expenditure::find($expenditure_id);

        //inisiasi nilai form agar sesuai dengan data yang mau diedit

        $this->form->detail = $this->expenditure->detail;
        $this->form->amount = strval(intval($this->expenditure->amount));
        $this->form->account_id = $this->expenditure->account_id;
        $this->form->currency_id = $this->expenditure->currency_id;

        //end inisiasi

        $this->dispatch('showModalExpJS');
    }

    public function updateExp()
    {

        $this->form->update($this->expenditure);

        //  flash('Data pengeluaran berhasil diubah', 'alert-success');

        $this->dispatch('reloadPowerGridExp');

    }

    #[\Livewire\Attributes\On('confirmRemoveExp')]
    public function confirmDeleteExp($expenditure_id)
    {

        $this->dispatch('removeConfirmExpJS', expenditure_id: $expenditure_id);

    }

    #[\Livewire\Attributes\On('removeExp')]
    public function removeExp($expenditure_id)
    {

        $expenditure = Expenditure::with(['currency'])->where('id', $expenditure_id)->first();

        $expenditure->delete();

        $currency = $expenditure->currency->name;

        $formattedAmount = $currency.' '.number_format($expenditure->amount, 0, ',', '.');

        $admin = Auth::user();

        insertLog($admin->name, request()->ip(), 'Hapus Pengeluaran', '-', $expenditure->detail." $formattedAmount", 2);

        $this->dispatch('reloadPowerGridExp');

    }
}
