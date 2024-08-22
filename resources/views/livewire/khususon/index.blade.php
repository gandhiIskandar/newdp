<div class="row">
    @php

        $totalDepo = $totalTransaksi->total_new_depo + $totalTransaksi->total_re_depo;
        $totalProfit = $totalDepo - $totalTransaksi->total_wd;
    @endphp

    <x-partials.data-card-2 :data="$totalTransaksi->total_re_depo" icon="repeat" color="bg-success" currency="true">Total Re-deposit Hari
        ini</x-partials.data-card-2>

    <x-partials.data-card-2 :data="$totalTransaksi->total_new_depo" icon="post_add" color="bg-primary" currency="true">Total New Deposit Hari
        ini</x-partials.data-card-2>

    <x-partials.data-card-2 :data="$totalDepo" icon="attach_money" color="bg-info" currency="true">Total Deposit Hari
        ini</x-partials.data-card-2>

    <x-partials.data-card :data="$totalTransaksi->total_wd" date="Hari ini" icon="ph-duotone ph-money" color="bg-light-warning"
        :currency="true">Total Withdraw</x-partials.data-card>




    <x-partials.data-card :data="$totalProfit" date="Hari ini" icon="ph-duotone ph-chart-bar" color="bg-light-success"
        :currency="true">Total Profit</x-partials.data-card>

    <x-partials.todo-list :tasks="$tasks" />
    <div class="col-sm-8">

        @if ($this->error == null)
            <div class="row">

                @foreach ($currencyData as $data)
                    <x-partials.data-card :data="$data->price" date="Hari ini" isImage="{{ $data->isCrypto }}"
                        icon="{{ $data->src }}" color="bg-light-success"
                        width="col-sm-6">{{ $data->currency }}</x-partials.data-card>
                @endforeach

            </div>
        @else
            <div class="card" style="height: 40vh">
                <div class="card-body text-center">
                    <div class="avtar avtar-l bg-light-danger rounded-circle mb-5">
                        <i class="ph-duotone ph-link-break f-30"></i>
                    </div>

                    <p class="f-20 px-5 mb-3">{{ $error }}</p>



                    <button type="button" wire:loading.attr='disabled' class="btn btn-primary"
                        wire:click='proccessDataStats'>Refresh</button>
                </div>
            </div>
        @endif
    </div>


    @if (privilegeViewTransaction() && session('website_id') != 5 && session('website_id') != 6)
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Data Transaksi Harian</h5>




                        @if (privilegeAddTransaction())
                            <button data-pc-animate="fade-in-scale" type="button" class="btn btn-primary"
                                data-bs-toggle="modal" data-bs-target="#animateModal" style="width: 200px;"
                                type="button">Tambah Transaksi</button>
                        @endif
                    </div>
                </div>
                <div class="card-body">


                    <livewire:p-g-transaction-table />

                </div>
            </div>
        </div>
    @else
    @endif

    <livewire:modal-input />
</div>
