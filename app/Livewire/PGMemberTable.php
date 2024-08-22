<?php

namespace App\Livewire;

use App\Models\Member;
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

final class PGMemberTable extends PowerGridComponent
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
        return Member::query()->where('website_id', session('website_id'));
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('username')
            ->add('total_wd', fn ($member) => $this->toRupiah($member->total_wd))
            ->add('phone_number')

            ->add('total_depo', fn ($member) => $this->toRupiah($member->total_depo))
            ->add('depo_wd', fn ($member) => $this->toRupiah($member->total_depo - $member->total_wd));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Username', 'username')
                ->sortable()
                ->searchable()->hidden(isHidden: ! privilegeViewUsernameMember(), isForceHidden: true),
            // Column::make('Phone number', 'phone_number')
            //     ->sortable()
            //     ->searchable(),

            Column::make('Total Depo', 'total_depo')
                ->sortable()
                ->searchable()->hidden(isHidden: ! privilegeViewTotalDepoMember(), isForceHidden: true),

            Column::make('Total Withdraw', 'total_wd')
                ->sortable()
                ->searchable()->hidden(isHidden: ! privilegeViewTotalWithdrawMember(), isForceHidden: true),

            Column::make('Depo - Withdraw', 'depo_wd')->hidden(isHidden: ! privilegeViewSumMember(), isForceHidden: true),

            Column::action('Action')->hidden(isHidden: ! privilegeEditMember() && ! privilegeRemoveMember(), isForceHidden: true),

        ];
    }

    public function filters(): array
    {
        return [];
    }

    // #[\Livewire\Attributes\On('edit')]
    // public function edit($rowId): void
    // {
    //     $this->js('alert('.$rowId.')');
    // }

    public function removeConfirmation()
    {

        $this->js('connfirmation("Yakin ingin hapus member ini?")');
    }

    #[\Livewire\Attributes\On('reloadPowerGridMember')]
    public function reloadData()
    {

        //untuk refresh data
        $this->fillData();
    }

    #[\Livewire\Attributes\On('removeMember')]
    public function removeMember($member_id)
    {

        $member = Member::find($member_id);
        $member->delete();
    }

    public function actions(Member $row): array
    {

        return [
            Button::add('edit')
                ->slot('Edit')
                ->id()
                ->class('btn btn-primary')
                ->dispatch('showEditModal', ['member_id' => $row->id]),

            Button::add('remove')
                ->slot('Hapus')
                ->id()
                ->class('btn btn-danger')
                ->dispatch('confirmRemoveMember', ['member' => $row]),
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
            Rule::button('edit')
                ->when(fn () => ! privilegeEditMember())
                ->hide(),

            Rule::button('remove')
                ->when(fn () => ! privilegeRemoveMember())
                ->hide(),
        ];
    }
}
