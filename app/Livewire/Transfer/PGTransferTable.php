<?php

namespace App\Livewire\Transfer;

use App\Models\Transfer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class PGTransferTable extends PowerGridComponent
{
    use WithExport;

    public $isTTAtas;

    public function setUp(): array
    {

        $this->isTTAtas = true;

        if (request()->is('pinjam-atas')) {
            $this->isTTAtas = false;
        }

        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {



        return Transfer::with(['website', 'account.bank', 'accountTransfer.bank'])->where('tt_atas', $this->isTTAtas);
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function generateValueRekening($transfer)
    {

        if ($transfer->accountTransfer == null) {
            return 'null';
        }
        $bank = $transfer->accountTransfer->bank->name;
        $under_name = $transfer->accountTransfer->under_name;

        return $bank . ' - ' . $under_name;
    }

    public function generateValueRekeningWeb($transfer)
    {

        if ($transfer->account == null) {
            return 'null';
        }
        $bank = $transfer->account->bank->name;
        $under_name = $transfer->account->under_name;

        return $bank . ' - ' . $under_name;
    }

    #[\Livewire\Attributes\On('reloadTransfer')]
    public function reloadData()
    {

        //untuk refresh data
        $this->fillData();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('website_id', fn ($transfer) => $transfer->website->name)
            ->add('account_id', fn ($transfer) => $this->generateValueRekeningWeb($transfer))
            ->add('account_tt_id', fn ($transfer) => $this->generateValueRekening($transfer))
            ->add('amount', fn ($transfer) => toRupiah($transfer->amount, true))
            // ->add('tt_atas')
            ->add('created_at_formatted', fn ($transfer) => Carbon::parse($transfer->created_at)->translatedFormat('d F Y H:i'));
    }

    public function ttAtasColumn()
    {

        return [
            Column::make('Id', 'id'),
            Column::make('Website', 'website_id')->hidden(isHidden: !privilegeViewWebsiteTTAtas(), isForceHidden: false),
            Column::make('Rekening Website', 'account_id')->hidden(isHidden: !privilegeViewRekeningWebsiteTTAtas(), isForceHidden: false),
            Column::make('Rekening TT Atas', 'account_tt_id')->hidden(isHidden: !privilegeViewRekeningTransferTTAtas(), isForceHidden: false),
            Column::make('Jumlah', 'amount')
                ->sortable()
                ->searchable()->hidden(isHidden: !privilegeViewAmountTTAtas(), isForceHidden: false),


            Column::make('Tanggal', 'created_at_formatted', 'created_at')
                ->sortable()->hidden(isHidden: !privilegeViewDateTTAtas(), isForceHidden: false),


            Column::action('Action')->hidden(isHidden: !privilegeDeleteTTAtas() && !privilegeUpdateTTAtas(), isForceHidden: false),
        ];
    }

    public function pinjamAtasColumn()
    {

        return [
            Column::make('Id', 'id'),
            Column::make('Website', 'website_id')->hidden(isHidden: !privilegeViewWebsitePinjamAtas(), isForceHidden: false),
            Column::make('Rekening Website', 'account_id')->hidden(isHidden: !privilegeViewRekeningWebsitePinjamAtas(), isForceHidden: false),
            Column::make('Rekening Pinjam Atas', 'account_tt_id')->hidden(isHidden: !privilegeViewRekeningTransferPinjamAtas(), isForceHidden: false),
            Column::make('Jumlah', 'amount')
                ->sortable()
                ->searchable()->hidden(isHidden: !privilegeViewAmountPinjamAtas(), isForceHidden: false),


            Column::make('Tanggal', 'created_at_formatted', 'created_at')
                ->sortable()->hidden(isHidden: !privilegeViewDatePinjamAtas(), isForceHidden: false),


            Column::action('Action')->hidden(isHidden: !privilegeDeletePinjamAtas() && !privilegeUpdatePinjamAtas(), isForceHidden: false),
        ];
    }

    public function columns(): array
    {
        if ($this->isTTAtas) {
            return $this->ttAtasColumn();
        } else {
            return $this->pinjamAtasColumn();
        }
    }

    public function filters(): array
    {
        return [];
    }

    // #[\Livewire\Attributes\On('edit')]
    // public function edit($rowId): void
    // {
    //     $this->js('alert(' . $rowId . ')');
    // }

    public function actions(Transfer $row): array
    {
        return [
            Button::add('remove')
                ->slot('Delete')
                ->id()
                ->class('btn btn-danger')
                ->dispatch('deleteTransferConfirm', ['transfer' => $row]),
        ];
    }

    
    public function actionRules($row): array
    {
       

        if($this->isTTAtas){

            return [
                 // Hide button edit for ID 1
                 Rule::button('remove')
                     ->when(fn()=>!privilegeDeleteTTAtas())
                     ->hide(),
             ];
        }else{
            
            return [
                // Hide button edit for ID 1
                Rule::button('remove')
                    ->when(fn()=>!privilegeDeletePinjamAtas())
                    ->hide(),
            ];
        }
    }
    
}
