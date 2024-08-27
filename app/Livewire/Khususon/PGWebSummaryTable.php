<?php

namespace App\Livewire\Khususon;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class PGWebSummaryTable extends PowerGridComponent
{
    use WithExport;

    public string $primaryKey = 'website_id';

    public string $sortField = 'website_id';

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
        return Transaction::with('website')
        ->selectRaw('website_id, COUNT(*) as total_transaction ,SUM(CASE WHEN type_id = 1 THEN amount ELSE 0 END) AS total_wd,
        SUM(CASE WHEN type_id = 2 THEN amount ELSE 0 END) AS total_depo')
        ->groupBy('website_id');
           
    }

    public function relationSearch(): array
    {
        return [];
    }

public function totalAmount($transaction){
    $total = $transaction->total_depo - $transaction->total_wd;
    if($total < 0){
        return "<p class='text-danger m-0'>".toRupiah($total,true)."</p>"; 
    }else if($total > 0){
        return "<p class='text-success m-0'>".toRupiah($total,true)."</p>"; 
    }else{
        return $total;
    }
    
}

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
           
          
            ->add('website_id', fn($transaction)=>$transaction->website->name)
           ->add('total_transaction')
            ->add('total_depo',fn($transaction)=>toRupiah($transaction->total_depo,true))
            ->add('total_wd',fn($transaction)=>toRupiah($transaction->total_wd,true))
            ->add('total',fn($transaction)=>$this->totalAmount($transaction))
            ;
    }

    public function columns(): array
    {
        return [
        
            Column::make('Website', 'website_id'),
            Column::make('Jumlah Transaksi', 'total_transaction'),
            Column::make('Total Deposit', 'total_depo'),
            Column::make('Total Withdraw', 'total_wd'),
            Column::make('Depo - Withdraw', 'total'),


           
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }

    // #[\Livewire\Attributes\On('edit')]
    // public function edit($rowId): void
    // {
    //     $this->js('alert('.$rowId.')');
    // }

    // public function actions(Transaction $row): array
    // {
    //     return [
    //         Button::add('edit')
    //             ->slot('Edit: '.$row->id)
    //             ->id()
    //             ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
    //             ->dispatch('edit', ['rowId' => $row->id])
    //     ];
    // }

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
