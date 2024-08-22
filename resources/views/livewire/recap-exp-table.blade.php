<div class="col-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Data Pengeluaran</h5>
                @if (in_array(21, session('privileges')))
                    <button wire:click='$dispatch("showModalNonEditStateExp")' type="button" class="btn btn-primary"
                        style="width: 200px;" type="button">Tambah Pengeluaran</button>
                @endif
            </div>

            <div class="d-flex align-items-center">

                <p style="margin: 0px !important">Jenis waktu: </p>
                <select class="form-select w-auto ms-3 me-4" id="exp_rekap_type" required>
                    <option value=1 selected>Harian</option>

                    <option value=2>Bulanan</option>


                </select>



                <p style="margin: 0px !important" class="{{ $rekap_type != 1 ? 'd-none' : '' }}">Range tanggal</p>
                <input type="text" class="form-control w-auto ms-3 {{ $rekap_type != 1 ? 'd-none' : '' }}"
                    id="dates_exp" />
                <p style="margin: 0px !important" class="{{ $rekap_type != 2 ? 'd-none' : '' }}">Dari</p>
                <input id="month1" class="form-control w-auto ms-3 me-4 {{ $rekap_type != 2 ? 'd-none' : '' }}"
                    type="text" />
                <p style="margin: 0px !important" class="{{ $rekap_type != 2 ? 'd-none' : '' }}">Sampai</p>
                <input id="month2" class="form-control w-auto ms-3 {{ $rekap_type != 2 ? 'd-none' : '' }}"
                    type="text" />

            </div>

        </div>
        <div class="card-body" wire:ignore>

            <table id="dom-jqry7" class="table table-striped table-bordered nowrap" style="width: 100%">
                <thead>
                    <tr>
                        <th rowspan="2">Tanggal</th>
                        <th rowspan="2">User</th>
                        <th colspan="4" data-dt-order="disable" style="text-align: center !important">Pengeluaran</th>
                    </tr>

                    <tr>

                        
                        <th>BTC</th>
                        <th>USD</th>
                        <th>USDT</th>
                        <th>IDR</th>




                    </tr>
                </thead>
                <tbody>
                    @foreach ($expenditures as $expenditure)
                        <tr>

                            <td>{{ $expenditure->date }}</td>
                            <td>{{ $expenditure->role }}</td>
                            <td> {{ $expenditure->total_btc }} </td>
                            <td> {{ $expenditure->total_usd }} </td>
                            <td> {{ $expenditure->total_usdt }} </td>
                            <td> {{ $expenditure->total_idr }} </td>

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

                var table = $('#dom-jqry7').DataTable({
                    "responsive": true,
                    "order": [],
                    "columnDefs": [{
                        className: 'dt-center',
                        targets: '_all'
                    }],

                });

                $('#dates_exp').daterangepicker({
                    opens: 'right'
                }, function(start, end, label) {


                    $wire.dispatch('filterRangeExp', [start, end]);
                });


                $wire.on('returnDataExp', (data) => {



                    table.clear().draw();

                    var datax = [

                    ];

                    $.each(data.expenditures, function(index, value) {

                        var expenditure = [
                            value.date, value.role, value.total_btc, value.total_usd, value.total_usdt, value.total_idr 
                        ]

                        datax.push(expenditure);

                    });


                    table.rows.add(datax).draw();



                });
                $('#exp_rekap_type').on('change', function() {



                    var selectedValue = $(this).val();

                    $wire.dispatch('changeTypeRecapExp', [selectedValue]);
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

                    $wire.dispatch('filterRangeExp', [start, end]);

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
