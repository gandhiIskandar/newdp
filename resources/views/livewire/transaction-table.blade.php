<div class="col-12">

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Log Transaksi</h5>

                @if (privilegeAddTransaction())
                    <button data-pc-animate="fade-in-scale" type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#animateModal" style="width: 200px;" type="button">Tambah Transaksi</button>
                @endif
            </div>
            <div class="d-flex align-items-center">

                <p style="margin: 0px !important">Range tanggal: </p>
                <input type="text" class="form-control w-auto ms-2" name="dates" />

            </div>
        </div>
        <div class="card-body">



        </div>
    </div>
</div>


@push('script')

    @script
        <script>
            $(function() {
                var table = $('#dom-jqry').DataTable({
                    responsive: true,
                    "order": [],
                    "columnDefs": [{
                        className: 'dt-center',
                        targets: '_all'
                    }],
                    "columns": [{
                            data: 'username'
                        },
                        {
                            data: 'jenis'
                        },
                        {
                            data: 'jumlah'
                        },
                        {
                            data: 'baru'
                        },
                        {
                            data: 'tanggal'
                        }
                    ]
                });




                $('input[name="dates"]').daterangepicker({
                    opens: 'right'
                }, function(start, end, label) {


                    $wire.dispatch('tessee', [start, end]);
                });



                $wire.on('filterTable', (data) => {



                    table.clear().draw();

                    var datax = [

                    ];

                    $.each(data.transactions, function(index, value) {

                        var transaction = {
                            username: value.member.username,
                            jenis: value.type_id == 1 ? 'Withdraw' : 'Deposit',
                            jumlah: value.amount,
                            baru: value.new == 1 ? 'Ya' : 'Tidak',
                            tanggal: value.date
                        }

                        datax.push(transaction);

                    });


                    table.rows.add(datax).draw();



                });

                $wire.on('localan', (data) => {




                    table.clear().draw();

                    var datax = [

                    ];

                    $.each(data.transactions, function(index, value) {

                        var transaction = {
                            username: value.member.username,
                            jenis: value.type_id == 1 ? 'Withdraw' : 'Deposit',
                            jumlah: value.amount,
                            baru: value.new == 1 ? 'Ya' : 'Tidak',
                            tanggal: value.date
                        }

                        datax.push(transaction);

                    });


                    table.rows.add(datax).draw();



                });
            });
        </script>
    @endscript

@endpush
