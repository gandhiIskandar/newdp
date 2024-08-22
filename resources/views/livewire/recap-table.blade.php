<div class="col-12">

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Data Rekap Transaksi</h5>
                @if (privilegeAddTransaction())
                    <button data-pc-animate="fade-in-scale" type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#animateModal" style="width: 200px;" type="button">Tambah Transaksi</button>
                @endif
            </div>
            <div class="d-flex align-items-center">

                <p style="margin: 0px !important">Jenis waktu: </p>
                <select class="form-select w-auto ms-3 me-4" id="rekap_type" required>
                    <option value=1 selected>Harian</option>

                    <option value=2>Bulanan</option>


                </select>



                <p style="margin: 0px !important" class="{{ $rekap_type != 1 ? 'd-none' : '' }}">Range tanggal</p>
                <input type="text" class="form-control w-auto ms-3 {{ $rekap_type != 1 ? 'd-none' : '' }}"
                    id="dates" />
                <p style="margin: 0px !important" class="{{ $rekap_type != 2 ? 'd-none' : '' }}">Dari</p>
                <input id="month1" class="form-control w-auto ms-3 me-4 {{ $rekap_type != 2 ? 'd-none' : '' }}"
                    type="text" />
                <p style="margin: 0px !important" class="{{ $rekap_type != 2 ? 'd-none' : '' }}">Sampai</p>
                <input id="month2" class="form-control w-auto ms-3 {{ $rekap_type != 2 ? 'd-none' : '' }}"
                    type="text" />

            </div>
        </div>
        <div class="card-body" wire:ignore>

            <table id="dom-jqry1" class="table table-striped table-bordered nowrap" style="width: 100%">
                <thead>
                    <tr>

                        <th rowspan="2" width="5%" style="font-size: 10px;">No</th>
                        <th rowspan="2" style="font-size: 10px;">Tanggal</th>

                        <th colspan="2" style="font-size: 10px;  text-align:center !important  "
                            data-dt-order="disable">Total New Deposit</th>
                        <th colspan="2" style="font-size: 10px;  text-align:center !important"
                            data-dt-order="disable">Total Re-deposit</th>

                        <th style="font-size: 10px; text-align:center !important;" data-dt-order="disable"
                            colspan="2">Total Deposit</th>
                        <th colspan="2" style="font-size: 10px;  text-align:center !important"
                            data-dt-order="disable">Total Withdraw</th>
                        <th style="font-size: 10px;  text-align:center !important" data-dt-order="disable">Deposit -
                            Withdraw</th>
                    </tr>
                    <tr>

                        <th style="font-size: 10px;">Form </th>
                        <th style="font-size: 10px;">Jumlah </th>
                        <th style="font-size: 10px;">Form </th>
                        <th style="font-size: 10px;">Jumlah </th>
                        <th style="font-size: 10px;">Form</th>
                        <th style="font-size: 10px;">Jumlah</th>
                        <th style="font-size: 10px;">Form</th>
                        <th style="font-size: 10px;">Jumlah</th>
                        <th style="font-size: 10px;">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $transaction->date }}</td>
                         
                            <td>{{ $transaction->forms_new_deposit }}</td>
                            <td class="text-success">{{ $transaction->total_new_deposit }}</td>
                            <td>{{ $transaction->forms_redeposit }}</td>
                            <td class="text-success">{{ $transaction->total_redeposit }}</td>
                            <td>{{ $transaction->forms_deposit }}</td>
                            <td class="text-success">{{ $transaction->total_deposit }}</td>
                            <td>{{ $transaction->forms_withdraw }}</td>
                            <td class="text-danger">{{ $transaction->total_withdraw }}</td>
                            <td class={{ $transaction->dkw >= 0 ? 'text-success' : 'text-danger' }}>
                                {{ toRupiah($transaction->dkw, true) }}</td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>
    </div>
</div>



@push('script')


    @script
        <script>
            $(document).ready(function() {
                setDefaultMonth();

                $('#month1').datepicker({

                    minViewMode: 1,
                    format: 'mm-yyyy',

                });
                $('#month2').datepicker({

                    minViewMode: 1,
                    format: 'mm-yyyy',

                });

                rangeMonthListener();

                $('#rekap_type').on('change', function() {



                    var selectedValue = $(this).val();
                    $wire.dispatch('changeType', [selectedValue]);
                });

                var table = $('#dom-jqry1').DataTable({
                    "responsive": true,
                    "order": [],
                    "columnDefs": [{
                        className: 'dt-center',
                        targets: '_all'
                    }],

                });

                // //format tambah data untuk di js callback livewire nanti
                // var a = [[1,2,3,4,5,6,7,8,9,10], [1,1,1,1,1,1,1,1,1,1]];

                // table.rows.add(a).draw();

                $('#dates').daterangepicker({
                    opens: 'right'
                }, function(start, end, label) {


                    $wire.dispatch('filterRange', [start, end]);
                });



                $wire.on('returnData', (data) => {



                    table.clear().draw();

                    var datax = [

                    ];

                    $.each(data.transactions, function(index, value) {

                        var transaction = [
                            index + 1, value.date, value.forms_deposit, value.total_deposit, value
                            .forms_new_deposit, value.total_new_deposit, value.forms_redeposit,
                            value.total_redeposit, value.forms_withdraw, value.total_withdraw, value
                            .dkw
                        ]

                        datax.push(transaction);

                    });


                    table.rows.add(datax).draw();



                });
            });


            function rangeMonthListener() {

                // Variabel untuk menyimpan nilai terakhir dari kedua input
                var value1 = $('#month1').val();
                var value2 = $('#month2').val();

                // Fungsi untuk melakukan aksi ketika kedua nilai berubah


                // Event listener untuk input pertama

                $(document).on('change', '#month1', function() {


                    value1 = $(this).val();
                    value2 = '';
                    if (value1 && value2) { // Pastikan kedua nilai tidak kosong
                        onValuesChanged(value1, value2);
                    }
                });

                // Event listener untuk input kedua
                $(document).on('change', '#month2', function() {
                    value2 = $(this).val();
                    if (value1 && value2) { // Pastikan kedua nilai tidak kosong
                        onValuesChanged(value1, value2);
                    }
                });

            }

            function onValuesChanged(start, end) {

                var [month1, year1] = start.split('-').map(Number);
                var [month2, year2] = end.split('-').map(Number);

                var dateObj1 = new Date(year1, month1 - 1); // Month is 0-indexed in JavaScript Date
                var dateObj2 = new Date(year2, month2 - 1);




                if (dateObj1 > dateObj2) {
                    alert('Range yang Anda input Salah');
                } else {

                    $wire.dispatch('filterRange', [start, end]);

                }

            }

            function setDefaultMonth() {
                // Mendapatkan bulan dan tahun saat ini
                const now = new Date();
                const month = String(now.getMonth() + 1).padStart(2, '0'); // Menggunakan padStart untuk memastikan dua digit
                const year = now.getFullYear();

                // Mengatur nilai input dengan format MM-YYYY
                $('#month1').val(`${month}-${year}`);
                $('#month2').val(`${month}-${year}`);
            }
        </script>
    @endscript

@endpush
