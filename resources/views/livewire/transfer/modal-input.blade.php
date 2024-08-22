<div wire:ignore.self class="modal fade modal-animate" id="modalTransfer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title">Tambah TT Atas</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body">
                <x-partials.flash-message />
                <form wire:submit='procedTransfer'>
                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlSelect1">Website</label>
                        <select class="form-select" wire:model.live='form.website_id' id="exampleFormControlSelect1" required>
                            <option value="" selected>Pilih Website</option>
                            @foreach ($websites as $website)
                                <option value={{ $website->id }} >{{ $website->name }}</option>
                                
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlSelect1">Rekening</label>
                        <select class="form-select" wire:model.live='form.account_id' id="exampleFormControlSelect1" required>
                            <option value="" selected>Pilih Rekening Website</option>
                            @foreach ($accounts as $account)
                                <option value={{ $account->id }}>{{ $account->bank->name." - ".$account->under_name }}</option>
                                
                            @endforeach
                        </select>
                    </div>


         
                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlSelect1">Rekening TT Atas</label>
                        <select class="form-select" wire:model.live='form.account_tt_id' id="exampleFormControlSelect1" required>
                            <option value="" selected>Pilih Rekening TT Atas</option>
                            @foreach ($accounts_tt as $account)
                                <option value={{ $account->id }}>{{ $account->bank->name." - ".$account->under_name }}</option>
                                
                            @endforeach
                        </select>
                    </div>

                    @if(!$isTTAtas)
                    <label class="form-label" for="amount">Jumlah</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Rp</span>
                        <input type="text" id="amount_input" wire:model='form.amount'
                            class="form-control" aria-label="Amount (to the nearest dollar)" required />

                    </div>
                    @endif

                      

        

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary shadow-2">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>


@push('script')

    @script
        <script>
        
            $wire.on('showModalTransferJS', (data) => {

                $('#modalTransfer').modal('show');


            });

            $wire.on('deleteTransferConfirmJS', (data) => {
                if (confirm('Yakin ingin hapus transfer ini ')) {
                    $wire.dispatch('removeTransfer', [data.transfer]);
                }
            });
        </script>
    @endscript


@endpush
