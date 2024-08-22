@push('css')
    <style>
        /* berguna untuk membatasi panjang text detail agar tidak terlalu lebar */

        #table_base_default td div {

            max-width: 200px !important;
            overflow-wrap: break-word;
            text-wrap: wrap;
        }
    </style>
@endpush

<div class="row">
    <div class="col-md-12">


        <div class="col-md-12 mb-3">
            <select wire:model.live='jenisTabel' class="form-select rounded-3 form-select-sm w-auto">
                <option value=2>Rekap</option>
                <option selected value=1>Catatan</option>
            </select>
        </div>
    </div>
    @if ($jenisTabel == 1)
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Log Pengeluaran</h5>
                        @if (privilegeAddExpenditure())
                            <button wire:click='$dispatch("showModalNonEditStateExp")' type="button"
                                class="btn btn-primary" style="width: 200px;" type="button">Tambah Pengeluaran</button>
                        @endif
                    </div>

                </div>
                <div class="card-body">

                    <livewire:p-g-expenditure-table />

                </div>
            </div>
        </div>
    @else
        <livewire:recap-exp-table />
    @endif


    <livewire:modal-input-exp />

</div>


@push('script')

    @script
        <script>
            $(document).ready(function() {

            });
        </script>
    @endscript
@endpush
