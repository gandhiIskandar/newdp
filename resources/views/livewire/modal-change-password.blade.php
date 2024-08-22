<div wire:ignore.self class="modal fade modal-animate" id="changePassword" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ganti Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body">
                <x-partials.flash-message />
                <form wire:submit='changePassword'>

                    <div class="mb-3">
                        <label class="form-label" for="exampleInputEmail1">Password Lama</label>
                        <input type="password" class="form-control" wire:model="password" id="exampleInputEmail1"
                            placeholder="Masukan Keterangan" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="exampleInputEmail1">Password Baru</label>
                        <input type="password" class="form-control" wire:model="newPassword" id="exampleInputEmail1"
                             required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="exampleInputEmail1">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" wire:model="confirmPassword" id="exampleInputEmail1" required />
                    </div>


                
                  

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary shadow-2">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>