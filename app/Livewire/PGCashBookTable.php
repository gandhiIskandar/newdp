<?php

namespace App\Livewire;

use App\Models\CashBook;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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

final class PGCashBookTable extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
        // $this->showCheckBox();

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
        return CashBook::query()->with(['type', 'user']);
    }

    public function relationSearch(): array
    {
        return [];
    }

    #[\Livewire\Attributes\On('reloadPowerGridCashBooks')]
    public function reloadData()
    {

        //untuk refresh data
        $this->fillData();

    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('type_id', fn ($cashBook) => $cashBook->type->name)
            ->add('amount', fn ($cashBook) => toBaht($cashBook->amount))
            ->add('detail')
            ->add('user_id', fn ($cashBook) => $cashBook->user->name)
            ->add('created_at_formatted', fn ($cashBook) => Carbon::parse($cashBook->created_at)->translatedFormat('d F Y'));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Type', 'type_id')->hidden(isHidden: ! privilegeViewTypeCash(), isForceHidden: false),
            Column::make('Jumlah', 'amount')
                ->sortable()
                ->searchable()->hidden(isHidden: ! privilegeViewAmountCash(), isForceHidden: false),

            Column::make('Detail', 'detail')
                ->sortable()
                ->searchable()->hidden(isHidden: ! privilegeViewDetailCash(), isForceHidden: false),

            Column::make('User', 'user_id')->hidden(isHidden: ! privilegeViewUserCash(), isForceHidden: false),
            Column::make('Tanggal', 'created_at_formatted', 'created_at')
                ->sortable()->hidden(isHidden: ! privilegeViewDateCash(), isForceHidden: false),

            // Column::make('Created at', 'created_at')
            //     ->sortable()
            //     ->searchable(),

            Column::action('Action')->hidden(isHidden: ! privilegeEditCashBook() && ! privilegeRemoveCashBook(), isForceHidden: true),
        ];
    }

    public function filters(): array
    {
        return [

            Filter::datetimepicker('created_at','created_at_formatted')
                ->params([

                    'timezone' => 'Asia/Jakarta',

                ]),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    public function actions(CashBook $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit')
                ->id()
                ->class('btn btn-primary')
                ->dispatch('showModalCashBookEdit', ['cashbook_id' => $row->id]),

            Button::add('remove')
                ->slot('Hapus')
                ->id()
                ->class('btn btn-danger')
                ->dispatch('removeConfirmCashBook', ['cashbook_id' => $row->id]),
        ];
    }

    public function actionRules($row): array
    {
        return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn () => ! privilegeEditCashBook())
                ->hide(),

            Rule::button('remove')
                ->when(fn () => ! privilegeRemoveCashBook())
                ->hide(),
        ];
    }
}
