<div class="row">
    <div class="col-md-12">

    </div>

    <div class="col-12">

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>{{ $isTTAtas ? 'TT Atas' : 'Pinjam Atas' }}</h5>

                    @if ($isTTAtas)
                        @if (privilegeCreateTTAtas())
                            <button wire:click='$dispatch("showModalTransferNonEdit")' type="button"
                                class="btn btn-primary" style="width: 200px;" type="button">Tambah TT Atas</button>
                        @endif
                    @else
                        @if (privilegeCreatePinjamAtas())
                            <button wire:click='$dispatch("showModalTransferNonEdit")' type="button"
                                class="btn btn-primary" style="width: 200px;" type="button">Tambah Pinjam Atas</button>
                        @endif

                    @endif
                </div>

            </div>
            <div class="card-body">

                <livewire:transfer.p-g-transfer-table/>

            </div>
        </div>
    </div>
    <livewire:transfer.modal-input />
</div>
