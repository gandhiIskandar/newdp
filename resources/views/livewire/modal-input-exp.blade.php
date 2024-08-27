<div wire:ignore.self class="modal fade modal-animate" id="modalExp" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pengeluaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body">
                <x-partials.flash-message />
                <form wire:submit='proceedExp'>

                    <div class="mb-3">
                        <label class="form-label" for="exampleInputEmail1">Keterangan</label>
                        <input type="text" class="form-control" wire:model="form.detail" id="exampleInputEmail1"
                            placeholder="Masukan Keterangan" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlSelect1">Website</label>
                        <select class="form-select" wire:model.live='selectedWebsite' id="exampleFormControlSelect1" required>
                            <option value="" selected>Pilih Website</option>
                            @foreach ($websites as $website)
                            <option value={{ $website->id }}>{{ $website->name }}</option>
                                
                            @endforeach
                            

                        </select>
                    </div>


                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlSelect1">Rekening</label>
                        <select class="form-select" wire:model='form.account_id' id="exampleFormControlSelect1" required>
                            <option value="" selected>Pilih Rekening</option>
                            @foreach ($accounts as $account)
                            <option value={{ $account->id }}>{{ $account->bank->name." - ".$account->under_name }}</option>
                                
                            @endforeach
                            

                        </select>
                    </div>
                    <label class="form-label" for="amount">Jumlah</label>
                    <div class="input-group mb-3">
                        <select class="form-select" style="max-width: 100px" wire:model.change='form.currency_id' id="exampleFormControlSelect2" required>
                           
                            @foreach ($currencies as $currency)
                            <option value={{ $currency->id }} {{ $loop->iteration == 1 ? 'selected' : '' }} >{{ $currency->name }}</option>
                                
                            @endforeach
                            

                        </select>
                        <input type="text" id="amount_input"  wire:loading.attr="disabled"  wire:model.live.debounce.500ms='form.amount' class="form-control input-currency"
                            aria-label="Amount (to the nearest dollar)" required />
                            
                        </div>
                        <div wire:loading.block wire:target="form.amount">
                            <small id="value" class="form-text">Calculating...</small>
                        </div>
                        @if($form->valueIDR != 0)
                        <small id="value" class="form-text">{{ toRupiah($form->valueIDR, true) }}</small>
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
            $(document).ready(function() {

                $wire.on('showModalExpJS', (data) => {

                    $('#modalExp').modal('show');

                    if(data.amount != 0){
                        //gunakan ini agar mencegah bug ketika pakai wire:model value kembali 0 saat edit state
                    AutoNumeric.set('#amount_input', data.amount);
                 }


                });
                
                $wire.on('removeConfirmExpJS', (data)=>{
                if(confirm('Yakin ingin hapus data pengeluaran ini ?')){
                $wire.dispatch('removeExp',[data.expenditure_id]);
                }

            });

        });
        </script>
    @endscript


@endpush
