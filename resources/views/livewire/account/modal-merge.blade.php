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
                        <label class="form-label" for="exampleFormControlSelect1">Rekening Tujuan</label>
                        <select class="form-select" wire:model='selected' id="exampleFormControlSelect1" required>
                            @foreach ($accounts as $account)
                                <option value={{ $account->id }} {{ $loop->iteration == 1 ? 'selected' : '' }}>
                                    {{ $account->bank->name." - ".$account->under_name }}</option>
                            @endforeach

                        </select>
                    </div>

               


                




                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary shadow-2">Tambah Rekening</button>
                    </div>

                </form>


            </div>
        </div>

    </div>

 