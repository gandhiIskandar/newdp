<?php

namespace App\Livewire\MemberAccount;

use App\Models\MemberAccount;
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

final class PGMemberAccountTable extends PowerGridComponent
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
        return MemberAccount::with(['member', 'bank']);
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('member_id', fn ($memberAccount) => $memberAccount->member->username)
            ->add('bank_id', fn ($memberAccount) => $memberAccount->bank->name)
            ->add('number')
            ->add('under_name');

    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Member id', 'member_id'),
            Column::make('Bank id', 'bank_id'),
            Column::make('Number', 'number')
                ->sortable()
                ->searchable(),

            Column::make('Under name', 'under_name')
                ->sortable()
                ->searchable(),

            // Column::make('Created at', 'created_at_formatted', 'created_at')
            //     ->sortable(),

            // Column::make('Created at', 'created_at')
            //     ->sortable()
            //     ->searchable(),

            Column::action('Action')->hidden(isHidden: ! privilegeUpdateMemberAccount() && ! privilegeDeleteMemberAccount(), isForceHidden: true),

        ];
    }

    public function filters(): array
    {
        return [
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    #[\Livewire\Attributes\On('reloadMemberAccount')]
    public function getData(): void
    {
        $this->fillData();
    }

    public function actions(MemberAccount $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit')
                ->id()
                ->class('btn btn-primary')
                ->dispatch('showModalMemberAccountEdit', ['memberAccount_id' => $row->id]),

            Button::add('remove')
                ->slot('Remove')
                ->id()
                ->class('btn btn-danger')
                ->dispatch('deleteMemberAccountConfirm', ['memberAccount' => $row]),
        ];
    }

    public function actionRules($row): array
    {
        return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn () => ! privilegeUpdateMemberAccount())
                ->hide(),

            Rule::button('remove')
                ->when(fn () => ! privilegeDeleteMemberAccount())
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
