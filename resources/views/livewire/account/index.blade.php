<div class="row">
    <div class="col-md-12">
        <livewire:account.modal-account />



    </div>

    <div class="col-12">

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Rekening</h5>

                    <div>
                        <button wire:click='$dispatch("showModalNonEditStateAccount")' type="button"
                            class="btn btn-primary" style="width: 200px;" type="button">Tambah Rekening</button>

                            @if(session('website_id') != 5)
                        <button data-pc-animate="fade-in-scale" type="button" class="btn btn-primary"
                            data-bs-toggle="modal" data-bs-target="#modalmerge" style="width: 200px;"
                            type="button">Gabung Saldo</button>
                            @endif
                    </div>
                </div>

            </div>
            <div class="card-body">

                <livewire:account.p-g-account-table />

            </div>
        </div>
    </div>
    <livewire:account.modal-merge />
</div>
