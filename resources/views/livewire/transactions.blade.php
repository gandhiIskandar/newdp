<div class="row">

    <div class="col-md-4 mb-3">



        <div class="form-floating">

            <select wire:model.live='jenisTabel' id="floatingSelect" class="form-select">
                <option value=2>Rekap</option>
                <option selected value=1>Log</option>
            </select>
            <label for="floatingSelect">Pilih Jenis Data</label>
        </div>


    </div>
    @if ($jenisTabel == 1)
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Log Transaksi</h5>
                        @if (in_array(5, session('privileges')) || in_array(9, session('privileges')))
                            <button wire:click='$dispatch("showModalNonEditState")' type="button"
                                class="btn btn-primary" style="width: 200px;" type="button">Tambah Transaksi</button>
                        @endif
                    </div>
                    {{-- <div class="d-flex align-items-center">
    
                    <p style="margin: 0px !important">Range tanggal: </p>
                    <input type="text" class="form-control w-auto ms-2" name="dates" />
    
                </div> --}}
                </div>
                <div class="card-body">

                    <livewire:p-g-transaction-table />

                </div>
            </div>
        </div>
    @else
        <livewire:recap-table />
    @endif
    <livewire:modal-input />
</div>
