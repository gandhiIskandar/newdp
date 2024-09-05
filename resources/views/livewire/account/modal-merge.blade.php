<div wire:ignore.self class="modal fade modal-animate" id="modalmerge" tabindex="80000" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gabung Saldo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body">
                <x-partials.flash-message />
                <form wire:submit='merge'>
                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlSelect1">Rekening Asal</label>
                        <select class="form-select" wire:model.live.debounce.200ms='from' id="exampleFormControlSelect1" required>
                            
                            <option value="" selected>Pilih rekening asal terlebih dahulu</option>
                            @foreach ($from_accounts as $account)
                                <option value={{ $account->id }}>
                                    {{ $account->bank->name." - ".$account->under_name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlSelect1">Rekening Tujuan</label>
                        <select class="form-select" {{ $from==null ? 'disabled' : '' }} wire:model.live.debounce.200ms='selected' id="exampleFormControlSelect1" required>
                            <option value="" selected>Pilih rekening tujuan</option>
                            @foreach ($to_accounts as $account)
                                <option value={{ $account->id }}>
                                    {{ $account->bank->name." - ".$account->under_name }}</option>
                            @endforeach

                        </select>
                    </div>

                    <label class="form-label" for="amount">Jumlah</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Rp</span>
                        <input type="text" id="amount_input" wire:model='amount'
                            class="form-control" aria-label="Amount (to the nearest dollar)" required />

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary shadow-2">Submit</button>
                    </div>

                </form>


            </div>
        </div>

    </div>

 @push('script')
 @script
 <script>
     $(document).ready(function() {
        new AutoNumeric('#amount_input', {
                    currencySymbol: '',
                    decimalCharacter: ',',
                    decimalPlaces: 0,
                    digitGroupSeparator: '.',
                });

                $wire.on('input-succed', (data) => {
                    AutoNumeric.set('#amount_input', 0);
                });

     });
 </script>
 @endscript
 @endpush