<div wire:ignore.self class="modal fade modal-animate" id="modalAccount" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rekening</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body">
                <x-partials.flash-message />
                <form wire:submit='proccedAccount'>
                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlSelect1">Rekening</label>
                        <select class="form-select" wire:model='form.bank_id' id="exampleFormControlSelect1" required>
                            @foreach ($banks as $bank)
                                <option value={{ $bank->id }} {{ $loop->iteration == 1 ? 'selected' : '' }}>
                                    {{ $bank->name }}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="exampleInputEmail1">Atas Nama Rekening</label>
                        <input type="text" class="form-control" wire:model="form.under_name" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="exampleInputEmail1">Nomor Rekening</label>
                        <input type="text" class="form-control" wire:model="form.number" required />
                    </div>


                    <label class="form-label" for="amount">Saldo Awal</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Rp</span>
                        <input type="text" id="amount" wire:model='form.balance'
                            class="form-control input-currency" required />





                    </div>





                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary shadow-2">Tambah Rekening</button>
                    </div>

                </form>


            </div>
        </div>

    </div>

    @push('script')

        @script
            <script>
                $wire.on('showModalAccountJS', (data) => {

                    $('#modalAccount').modal('show');


                });


                $wire.on('deleteAccountConfirmJS', (data) => {
                    if (confirm('Yakin ingin hapus rekening ini ' + data.account.bank.name + '?')) {
                        $wire.dispatch('removeAccount', [data.account]);
                    }
                });
            </script>
        @endscript


    @endpush
