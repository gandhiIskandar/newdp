<?php

namespace App\Livewire;

use App\Livewire\Forms\CashBookForm;
use App\Models\CashBook;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalInputKas extends Component
{
    public CashBookForm $form;

    public $edit;

    public $cashBook;

    public function render()
    {
        return view('livewire.modal-input-kas');
    }

    public function proceedCashBook()
    {
        $this->form->amount = str_replace('.', '', $this->form->amount);

        if (! $this->edit) {
            $this->insertCashBook();
        } else {
            $this->updateCashBook();
        }
    }

    //fungsi inisiasi data member untuk edit transaksi
    #[\Livewire\Attributes\On('showModalCashBookEdit')]
    public function showModalInputEditState($cashbook_id)
    {

        $this->edit = true; //aktifkan state edit

        $this->cashBook = CashBook::find($cashbook_id);

        //inisiasi nilai form agar sesuai dengan data yang mau diedit

        $this->form->detail = $this->cashBook->detail;
        $this->form->amount = $this->cashBook->amount;
        $this->form->type_id = $this->cashBook->type_id;
        //end inisiasi

        $this->dispatch('showModalCashBookJS');
    }

    public function updateCashBook()
    {

        $this->form->update($this->cashBook);

        flash('Data transaksi berhasil diubah', 'alert-success');

        $this->dispatch('reloadPowerGridCashBooks');

    }

    public function insertCashBook()
    {

        $cashbook = $this->form->create();

        $cashbook->date = Carbon::parse($cashbook->created_at)->translatedFormat('d F Y');

        $this->dispatch('cashBookCreated', cashbook: $cashbook);
        $this->dispatch('reloadPowerGridCashBooks');
    }

    #[\Livewire\Attributes\On('showModalNonEditStateCashBook')]
    public function showModalNonEditState()
    {
        $this->form->reset();

        $this->edit = false;

        $this->dispatch('showModalCashBookJS');
    }

    #[\Livewire\Attributes\On('removeConfirmCashBook')]
    public function removeConfirm($cashbook_id)
    {

        $this->dispatch('removeConfirmCashBookJS', cashbook_id: $cashbook_id);
    }

    #[\Livewire\Attributes\On('removeCashBook')]
    public function removeCashBook($cashbook_id)
    {

        $cashBook = CashBook::where('id', $cashbook_id)->first();

        $cashBook->delete();

        $admin = Auth::user();

        insertLog($admin->name, request()->ip(), 'Hapus Catatan Kas', $cashBook->type->name, $cashBook->detail.' '.toBaht($cashBook->amount), 2);

        $this->dispatch('reloadPowerGridCashBooks');

    }
}
