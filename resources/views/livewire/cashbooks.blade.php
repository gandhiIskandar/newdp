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
                        <h5>Log Cashbook</h5>

                        @if (privilegeAddCashBook())
                            <button wire:click='$dispatch("showModalNonEditStateCashBook")' type="button"
                                class="btn btn-primary" style="width: 200px;" type="button">Tambah Catatan Kas</button>
                        @endif
                    </div>

                </div>
                <div class="card-body">

                    <livewire:p-g-cash-book-table />

                </div>
            </div>
        </div>
    @else
        <livewire:recap-cashbook-table />
    @endif
    <livewire:modal-input-kas />
</div>
