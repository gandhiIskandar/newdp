<?php

namespace App\Livewire;

use App\Models\Expenditure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
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

final class PGExpenditureTable extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {

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

        $user = Auth::user();

        return Expenditure::query()->where('website_id', session('website_id'))->with(['user.role', 'account.bank', 'currency'])->whereHas('user', function ($query) use ($user) {
            $query->whereHas('role', function ($query) use ($user) {
                $query->where('role_id', $user->role_id);
            });
        })->latest();

        //ambil data pengeluaran berdasarkan role_id tetapi role_id ada di dalam user, jadi harus menggunakan whereHas
    }

    public function relationSearch(): array
    {
        return [];
    }

    #[\Livewire\Attributes\On('reloadPowerGridExp')]
    public function reloadData()
    {

        //untuk refresh data
        $this->fillData();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('user_id', fn($expenditure) => $expenditure->user->name)
            ->add('amount', fn($expenditure) =>  toRupiah($expenditure->amount, true) )
            ->add('detail')
            ->add('account_id', fn($expenditure) => $expenditure->account->bank->name . " - " . $expenditure->account->under_name)
            ->add('created_at_formatted', fn($expenditure) => Carbon::parse($expenditure->created_at)->translatedFormat('d F Y  H:i'));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('User', 'user_id')->hidden(isHidden: ! privilegeViewUserExp(), isForceHidden: false),
            Column::make('Jumlah', 'amount')
                ->sortable()
                ->searchable()->hidden(isHidden: ! privilegeViewAmountExp(), isForceHidden: false),
         //   Column::make('Mata Uang', 'currency_id')->hidden(isHidden: ! privilegeViewCurrencyExp(), isForceHidden: false),

            Column::make('Detail', 'detail')
                ->sortable()
                ->searchable()->hidden(isHidden: ! privilegeViewDetailExp(), isForceHidden: false),

            Column::make('Bank', 'account_id')->hidden(isHidden: ! privilegeViewBankExp(), isForceHidden: false),
            Column::make('Tanggal', 'created_at_formatted', 'created_at')
                ->sortable()->hidden(isHidden: ! privilegeViewDateExp(), isForceHidden: false),

            // Column::make('Created at', 'created_at')
            //     ->sortable()
            //     ->searchable(),

            Column::action('Action')->hidden(isHidden: ! privilegeEditExpenditure() && ! privilegeRemoveExpenditure(), isForceHidden: true),
        ];
    }

    public function filters(): array
    {
        if (privilegeViewDateExp()) {

            return [

                Filter::datetimepicker('created_at_formatted', 'created_at')
                    ->params([

                        'timezone' => 'Asia/Jakarta',

                    ]),
            ];
        }
        return [];
    }

    // #[\Livewire\Attributes\On('edit')]
    // public function edit($rowId): void
    // {
    //     $this->js('alert('.$rowId.')');
    // }

    public function actions(Expenditure $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit')
                ->id()
                ->class('btn btn-primary')
                ->dispatch('showModalExpEdit', ['expenditure_id' => $row->id]),

            Button::add('remove')
                ->slot('Hapus')
                ->id()
                ->class('btn btn-danger')
                ->dispatch('confirmRemoveExp', ['expenditure_id' => $row->id]),
        ];
    }

    public function actionRules($row): array
    {
        return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn() => ! privilegeEditExpenditure())
                ->hide(),

            Rule::button('remove')
                ->when(fn() => ! privilegeRemoveExpenditure())
                ->hide(),
        ];
    }
}
