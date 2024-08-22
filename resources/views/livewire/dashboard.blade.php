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

    <div class="col-sm-8" wire:ignore>
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Data Transaksi Harian</h5>

                    @if (in_array(5, session('privileges')) || in_array(9, session('privileges')))
                        <button data-pc-animate="fade-in-scale" type="button" class="btn btn-primary"
                            data-bs-toggle="modal" data-bs-target="#animateModal" style="width: 200px;"
                            type="button">Tambah Transaksi</button>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="dt-responsive">
                    <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                                <th>Baru</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->member->username }}</td>
                                    <td>{{ $transaction->type->name }}</td>
                                    <td>@currency($transaction->amount)</td>
                                    <td>
                                        @if ($transaction->new)
                                            Ya
                                        @else
                                            Tidak
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Username</th>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                                <th>Baru</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <livewire:modal-input />

</div>


@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/dataTables.bootstrap5.min.css') }}" />
    <link href="{{ asset('assets/css/plugins/animate.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('assets/js/plugins/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/dataTables.bootstrap5.min.js') }}"></script>

    <script>
        $('#dom-jqry').DataTable();
    </script>
@endpush
