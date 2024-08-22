<?php

namespace App\Livewire;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class PGTransactionTable extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
        // $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()
                ->showSearchInput()
                ->showToggleColumns(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): ?Builder
    {
        if (in_array(4, session('privileges')) && in_array(8, session('privileges'))) {
            return Transaction::query()->with(['type', 'member', 'account.bank', 'memberAccount.bank', 'bank'])->where('website_id', session('website_id'))->latest();
        } elseif (in_array(4, session('privileges'))) {
            return Transaction::query()->with(['type', 'member', 'account.bank', 'memberAccount.bank', 'bank'])->where('type_id', 2)->where('website_id', session('website_id'))->latest(); // 2 adalah type_id dari deposit

        } elseif (in_array(8, session('privileges'))) {

            return Transaction::query()->with(['type', 'member', 'account.bank', 'memberAccount.bank', 'bank'])->where('type_id', 1)->where('website_id', session('website_id'))->latest(); // 1 adalah type_id dari withdraw
        }
    }

    public function relationSearch(): array
    {
        return [];
    }

    #[\Livewire\Attributes\On('reloadTransaction')]
    public function reloadData()
    {

        //untuk refresh data
        $this->fillData();
    }

    public function getFromAccount($transaction)
    {
        if ($transaction->type_id == 1) {
            $bank_admin_name = $transaction->account->bank->name ?? 'kosong';
            $bank_admin_uder_name = $transaction->account->under_name ?? 'kosong';

            return $bank_admin_name.' '.$bank_admin_uder_name;
        } else {
            return $transaction->bank->name ?? 'kosong';
        }
    }

    public function getToAccount($transaction)
    {
        if ($transaction->type_id == 1) {
            $bank_name_member = $transaction->memberAccount->bank->name ?? 'kosong';
            $bank_under_name_member = $transaction->memberAccount->under_name ?? 'kosong';

            return $bank_name_member.' '.$bank_under_name_member;
        } else {
            return $transaction->account->bank->name ?? 'kosong';
        }
    }

    public function fields(): PowerGridFields
    {

        return PowerGrid::fields()

            ->add('type_id', fn ($transaction) => $transaction->type->name)
            ->add('amount', fn ($transaction) => $transaction->type_id == 1 ? "<p class='text-danger m-0 text-center'>".$this->toRupiah($transaction->amount).'</p>' : "<p class='text-success m-0 text-center'>".$this->toRupiah($transaction->amount).'</p>')
            ->add('member_id', fn ($transaction) => $transaction->member->username ?? 'Member tidak ada')
            // ->add('new', fn ($transaction) => $transaction->new == 1 ? 'Ya' : 'Tidak')
            ->add('from_account', fn ($transaction) => $this->getFromAccount($transaction))
            ->add('to_account', fn ($transaction) => $this->getToAccount($transaction))
            ->add('created_at_formatted', fn ($transaction) => Carbon::parse($transaction->created_at)->translatedFormat('d F Y H:i'));
    }

    public function columns(): array
    {

        return [
            Column::make('Username', 'member_id')
                ->hidden(isHidden: ! privilegeViewUsernameTransaction(), isForceHidden: false),
            Column::make('Jenis Transaksi', 'type_id')->hidden(isHidden: ! privilegeViewTypeTransaction(), isForceHidden: false),
            Column::make('Jumlah', 'amount')
                ->sortable()
                ->searchable()

                ->bodyAttribute()->hidden(isHidden: ! privilegeViewAmountTransaction(), isForceHidden: false),

            // Column::make('Rekening', 'account_id')
            //     ->sortable()
            //     ->searchable(),

            Column::make('Dari Rekening', 'from_account')->hidden(isHidden: ! privilegeViewFromAccountTransaction(), isForceHidden: false),
            Column::make('Tujuan Rekening', 'to_account')->hidden(isHidden: ! privilegeViewToAccountTransaction(), isForceHidden: false),

            // Column::make('Baru', 'new')
            //     ->sortable()
            //     ->searchable(),

            Column::make('Tanggal', 'created_at_formatted', 'created_at')->hidden(isHidden: ! privilegeViewDateTransaction(), isForceHidden: false)
                ->sortable(),

            // Column::make('Created at', 'created_at')
            //     ->sortable()
            //     ->searchable(),

            Column::action('Action')->hidden(isHidden: ! privilegeEditTransaction() && ! privilegeRemoveTransaction() || Route::currentRouteName() === 'dashboard', isForceHidden: true),
        ];
    }

    public function filters(): array
    {
        return [

            Filter::datetimepicker('created_at', 'created_at_formatted')
                ->params([

                    'timezone' => 'Asia/Jakarta',

                ]),
        ];
    }

    public function actions(Transaction $row): array
    {

        return [
            Button::add('edit')
                ->slot('Edit')
                ->id()
                ->class('btn btn-primary')
                ->dispatch('showModalTransactionEdit', ['transaction_id' => $row->id]),

            Button::add('remove')
                ->slot('Hapus')
                ->id()
                ->class('btn btn-danger')
                ->dispatch('deleteTransactionConfirm', ['transaction' => $row]),
        ];
    }

    public function toRupiah($amount)
    {

        return 'Rp '.number_format($amount, 0, ',', '.');
    }

    public function actionRules($row): array
    {

        return [
            // Hide button edit for ID 1
            Rule::button('remove')
                ->when(
                    fn () => ! privilegeRemoveTransaction()
                )

                ->hide(),

            Rule::button('edit')
                ->when(
                    fn () => ! privilegeEditTransaction()
                )

                ->hide(),

        ];
    }
}
