<?php

namespace App\Livewire\Account;

use App\Models\Account;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class PGAccountTable extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
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
        return Account::query()->with(['website', 'bank'])->where('website_id', session('website_id'));
    }

    #[\Livewire\Attributes\On('reloadPowerGridAccount')]
    public function reloadData()
    {

        $this->fillData();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('bank_id', fn ($account) => $account->bank->name)
            ->add('number')
            ->add('under_name')
            ->add('balance', fn ($account) => toRupiah($account->balance, true))
            ->add('website_id', fn ($account) => $account->website->name ?? 'Belum Setting');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Bank', 'bank_id')
                ->sortable()
                ->searchable()->hidden(isHidden: ! privilegeViewBankAdminAccount(), isForceHidden: true),

            // Column::make('Created at', 'created_at_formatted', 'created_at')
            //     ->sortable(),
            Column::make('Website', 'website_id')
                ->sortable()->hidden(isHidden: ! privilegeViewWebsiteAdminAccount(), isForceHidden: true),
            Column::make('Nomor Rekening', 'number')
                ->sortable()->hidden(isHidden: ! privilegeViewNumberAdminAccount(), isForceHidden: true),

            Column::make('Nama', 'under_name')
                ->sortable()->hidden(isHidden: ! privilegeViewNameAdminAccount(), isForceHidden: true),

            Column::make('Saldo', 'balance')
                ->sortable()->hidden(isHidden: ! privilegeViewBalanceAdminAccount(), isForceHidden: true),

            // Column::make('Created at', 'created_at')
            //     ->sortable()
            //     ->searchable(),

            Column::action('Action')->hidden(isHidden: ! privilegeUpdateAdminAccount() && ! privilegeDeleteAdminAccount(), isForceHidden: true),
        ];
    }

    public function filters(): array
    {
        return [];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    public function actions(Account $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit')
                ->id()
                ->class('btn btn-primary')
                ->dispatch('showModalAccountEdit', ['account_id' => $row->id]),

            Button::add('remove')
                ->slot('Hapus')
                ->id()
                ->class('btn btn-danger')
                ->dispatch('deleteAccountConfirm', ['account' => $row]),
        ];
    }

    public function actionRules($row): array
    {
        return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn () => ! privilegeUpdateAdminAccount())
                ->hide(),

            Rule::button('remove')
                ->when(fn () => ! privilegeDeleteAdminAccount())
                ->hide(),
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
